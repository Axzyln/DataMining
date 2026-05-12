<?php
namespace App\Http\Controllers;

use App\Models\BakerInventory;
use App\Models\Recipe;
use App\Models\Recommendation;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RecommendationController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Latest batch — find by most recent created_at, not max(batch_id) which is not time-ordered for UUIDs
        $latestBatch = Recommendation::where('user_id', $userId)
            ->whereNotNull('batch_id')
            ->orderByDesc('created_at')
            ->value('batch_id');

        $recommendations = $latestBatch
            ? Recommendation::where('user_id', $userId)
                ->where('batch_id', $latestBatch)
                ->orderByDesc('score')
                ->get()
            : collect();

        // History: distinct batches excluding the latest, null batch_ids excluded
        $history = Recommendation::where('user_id', $userId)
            ->whereNotNull('batch_id')
            ->when($latestBatch, fn($q) => $q->where('batch_id', '!=', $latestBatch))
            ->select('batch_id', DB::raw('MAX(created_at) as generated_at'), DB::raw('COUNT(*) as count'))
            ->groupBy('batch_id')
            ->orderByDesc('generated_at')
            ->take(10)
            ->get();

        return view('baker.reccomendations', compact('recommendations', 'history', 'latestBatch'));
    }

    public function generate()
    {
        $userId = Auth::id();

        $allInventory = BakerInventory::where('user_id', $userId)->get();

        $inStock    = $allInventory->where('quantity', '>', 0);
        $outOfStock = $allInventory->where('quantity', '<=', 0);

        $windowDays = 7;
        $windowStart = now()->subDays($windowDays)->toDateString();

        $recentSales = Sale::where('user_id', $userId)
            ->whereDate('sale_date', '>=', $windowStart)
            ->select('product_name',
                DB::raw('SUM(quantity_sold) as total_qty'),
                DB::raw('SUM(total) as total_revenue'))
            ->groupBy('product_name')
            ->orderByDesc('total_qty')
            ->get();

        // Normalised lookup sets (lowercase) for inventory matching
        $inStockNames  = $inStock->mapWithKeys(fn($i) => [strtolower(trim($i->ingredient_name)) => $i->quantity]);
        $outStockNames = $outOfStock->map(fn($i) => strtolower(trim($i->ingredient_name)))->flip();

        // Cross-reference every recipe against the baker's actual inventory
        $allRecipes = Recipe::with('ingredients')->get();

        $feasible   = [];
        $infeasible = [];

        foreach ($allRecipes as $recipe) {
            $criticalMissing    = [];
            $criticalAvailable  = [];

            foreach ($recipe->ingredients as $ing) {
                $key = strtolower(trim($ing->ingredient_name));
                if (!$ing->is_critical) {
                    continue;
                }
                // Out of stock in inventory
                if (isset($outStockNames[$key])) {
                    $criticalMissing[] = $ing->ingredient_name . ' (out of stock)';
                // Not tracked in inventory at all — treat as unavailable
                } elseif (!isset($inStockNames[$key])) {
                    $criticalMissing[] = $ing->ingredient_name . ' (not in inventory)';
                } else {
                    $qty = $inStockNames[$key];
                    $criticalAvailable[] = "{$ing->ingredient_name}: {$qty} {$ing->unit}";
                }
            }

            if (empty($criticalMissing)) {
                $availStr = implode(', ', $criticalAvailable);
                $feasible[] = "- {$recipe->name} ({$recipe->category}) | ingredients on hand: {$availStr}";
            } else {
                $missingStr = implode(', ', $criticalMissing);
                $infeasible[] = "- {$recipe->name}: MISSING {$missingStr}";
            }
        }

        $feasibleText   = empty($feasible)   ? 'None — not enough ingredients in stock for any recipe.' : implode("\n", $feasible);
        $infeasibleText = empty($infeasible) ? 'None'                                                   : implode("\n", $infeasible);

        $inventoryText = $inStock->isEmpty()
            ? 'No ingredients currently in stock.'
            : $inStock->map(fn($i) => "- {$i->ingredient_name}: {$i->quantity} {$i->unit}")->join("\n");

        $outOfStockText = $outOfStock->isEmpty()
            ? 'None'
            : $outOfStock->map(fn($i) => "- {$i->ingredient_name}")->join("\n");

        $salesText = $recentSales->isEmpty()
            ? 'No sales in the past 7 days.'
            : $recentSales->map(fn($s) => "- {$s->product_name}: {$s->total_qty} units sold, ₱{$s->total_revenue} revenue")->join("\n");

        $maxRecs = (int) (\App\Models\Setting::get('ai_max_recommendations', '8'));

        $prompt = <<<PROMPT
You are a bakery business advisor for a Filipino bakery. Recommend which products the baker should bake TODAY based strictly on local data: their actual ingredient inventory and their sales from the past {$windowDays} days only.

CURRENT INVENTORY (in stock with quantities):
{$inventoryText}

OUT OF STOCK INGREDIENTS:
{$outOfStockText}

FEASIBLE RECIPES — cross-referenced against this baker's inventory (ingredients on hand listed):
{$feasibleText}

INFEASIBLE RECIPES — do NOT recommend any of these (missing required ingredients):
{$infeasibleText}

SALES DATA — past {$windowDays} days only (use this to gauge demand):
{$salesText}

Rules:
1. ONLY recommend products from the FEASIBLE RECIPES list. Do not invent products not in that list.
2. NEVER recommend from the INFEASIBLE RECIPES list regardless of past sales.
3. Prioritise products that sold well in the past 7 days AND have all ingredients available.
4. If a feasible product has no recent sales, rank it lower but still consider it if it uses perishable ingredients (eggs, milk, butter) that should be used soon.
5. Suggest up to {$maxRecs} products.

Return ONLY a valid JSON array — no markdown, no extra text. Each object must have:
- "product_name": string (exact name from the FEASIBLE RECIPES list)
- "score": integer 0–100 (recommendation strength)
- "reason": string (2 sentences — cite the actual ingredient quantities on hand and the 7-day sales figures)
- "required_ingredients": array of the required ingredient name strings for this product
PROMPT;

        $apiKey = env('GROQ_API_KEY');
        $model  = env('GROQ_MODEL', 'llama-3.3-70b-versatile');

        if (empty($apiKey)) {
            return redirect()->route('baker.recommendations.index')
                ->with('error', 'GROQ_API_KEY is not set in your .env file.');
        }

        try {
            $response = Http::timeout(30)
                ->withToken($apiKey)
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model'       => $model,
                    'messages'    => [
                        [
                            'role'    => 'system',
                            'content' => 'You are a bakery business advisor. Respond with valid JSON only — no markdown code fences, no explanation.',
                        ],
                        [
                            'role'    => 'user',
                            'content' => $prompt,
                        ],
                    ],
                    'temperature' => 0.6,
                    'max_tokens'  => 1200,
                ]);

            if (!$response->successful()) {
                throw new \Exception("Groq API returned HTTP {$response->status()}: {$response->body()}");
            }

            $raw = trim($response->json('choices.0.message.content') ?? '');
            $raw = preg_replace('/^```(?:json)?\s*/i', '', $raw);
            $raw = preg_replace('/\s*```$/', '', $raw);

            $items = json_decode($raw, true);

            if (!is_array($items) || empty($items)) {
                throw new \Exception('Groq returned unexpected content: ' . substr($raw, 0, 200));
            }

        } catch (\Exception $e) {
            Log::error('Groq recommendation error: ' . $e->getMessage());
            return redirect()->route('baker.recommendations.index')
                ->with('error', 'AI service error: ' . $e->getMessage());
        }

        $batchId = (string) Str::uuid();

        foreach (array_slice($items, 0, $maxRecs) as $item) {
            Recommendation::create([
                'user_id'              => $userId,
                'product_name'         => $item['product_name'] ?? 'Unknown',
                'score'                => min(100, max(0, (int) ($item['score'] ?? 0))),
                'reason'               => $item['reason'] ?? '',
                'required_ingredients' => $item['required_ingredients'] ?? [],
                'batch_id'             => $batchId,
            ]);
        }

        return redirect()->route('baker.recommendations.index')
            ->with('success', "Recommendations generated by Groq ({$model}).");
    }

    public function feedback(Request $request, Recommendation $recommendation)
    {
        if ($recommendation->user_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validate(['feedback' => ['required', 'in:up,down']]);

        // Toggle off if same feedback clicked again
        $newFeedback = $recommendation->feedback === $data['feedback'] ? null : $data['feedback'];
        $recommendation->update(['feedback' => $newFeedback]);

        return back()->with('success', 'Feedback recorded.');
    }

    public function batchHistory(string $batchId)
    {
        $userId = Auth::id();

        $items = Recommendation::where('user_id', $userId)
            ->where('batch_id', $batchId)
            ->orderByDesc('score')
            ->get();

        if ($items->isEmpty()) {
            abort(404);
        }

        $generatedAt = $items->first()->created_at;

        return view('baker.recommendations-history', compact('items', 'batchId', 'generatedAt'));
    }
}
