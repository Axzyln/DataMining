<?php
namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\BakerInventory;
use App\Models\Recommendation;
use Illuminate\Support\Facades\DB;

class RecommendationController extends Controller
{
    /** Catalog of bakery products and the ingredients each requires. */
    private array $catalog = [
        'Pandesal'         => ['flour', 'sugar', 'yeast', 'salt', 'butter'],
        'Ensaymada'        => ['flour', 'sugar', 'yeast', 'butter', 'eggs', 'cheese'],
        'Spanish Bread'    => ['flour', 'sugar', 'yeast', 'butter', 'milk'],
        'Cheese Bread'     => ['flour', 'sugar', 'yeast', 'cheese', 'butter'],
        'Monay'            => ['flour', 'sugar', 'yeast', 'salt'],
        'Chocolate Cake'   => ['flour', 'sugar', 'cocoa', 'eggs', 'butter', 'milk'],
        'Cupcake'          => ['flour', 'sugar', 'eggs', 'butter', 'milk'],
        'Brownies'         => ['flour', 'sugar', 'cocoa', 'eggs', 'butter'],
        'Cinnamon Roll'    => ['flour', 'sugar', 'yeast', 'butter', 'cinnamon', 'milk'],
        'Banana Bread'     => ['flour', 'sugar', 'eggs', 'butter', 'banana'],
    ];

    public function index()
    {
        $recommendations = Recommendation::where('user_id', auth()->id())
            ->orderByDesc('score')->get();
        return view('baker.recommendations', compact('recommendations'));
    }

    public function generate()
    {
        $userId = auth()->id();

        // Baker's available ingredients (lowercased for matching)
        $available = BakerInventory::where('user_id', $userId)
            ->where('quantity', '>', 0)
            ->pluck('ingredient_name')
            ->map(fn($n) => strtolower(trim($n)))
            ->toArray();

        // Historical sales — quantity per product
        $salesData = Sale::where('user_id', $userId)
            ->select('product_name', DB::raw('SUM(quantity_sold) as total'))
            ->groupBy('product_name')
            ->pluck('total', 'product_name')
            ->toArray();

        $maxSales = max([...array_values($salesData), 1]);

        // Clear old recommendations
        Recommendation::where('user_id', $userId)->delete();

        $results = [];
        foreach ($this->catalog as $product => $required) {
            $matched = 0;
            foreach ($required as $ing) {
                foreach ($available as $haveIng) {
                    if (str_contains($haveIng, strtolower($ing))) {
                        $matched++;
                        break;
                    }
                }
            }
            $ingredientScore = count($required) ? ($matched / count($required)) : 0;

            // Sales score: partial match on product name
            $salesScore = 0;
            foreach ($salesData as $name => $qty) {
                if (str_contains(strtolower($name), strtolower($product))
                    || str_contains(strtolower($product), strtolower($name))) {
                    $salesScore = $qty / $maxSales;
                    break;
                }
            }

            // Final weighted score
            $finalScore = round(($ingredientScore * 60) + ($salesScore * 40), 2);

            $reason = $this->buildReason($matched, count($required), $salesScore);

            $results[] = [
                'product_name'         => $product,
                'reason'               => $reason,
                'score'                => $finalScore,
                'required_ingredients' => json_encode($required),
                'user_id'              => $userId,
                'created_at'           => now(),
                'updated_at'           => now(),
            ];
        }

        usort($results, fn($a, $b) => $b['score'] <=> $a['score']);
        Recommendation::insert(array_slice($results, 0, 8));

        return redirect()->route('baker.recommendations.index')
            ->with('success', 'AI recommendations generated based on your ingredients and sales.');
    }

    private function buildReason(int $matched, int $total, float $salesScore): string
    {
        $parts = [];
        $parts[] = "$matched of $total required ingredients available";
        if ($salesScore > 0.7)      $parts[] = "strong sales history";
        elseif ($salesScore > 0.3)  $parts[] = "moderate sales history";
        elseif ($salesScore > 0)    $parts[] = "some sales history";
        else                        $parts[] = "new product opportunity";
        return implode(' · ', $parts);
    }
}