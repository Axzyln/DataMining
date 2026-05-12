<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class IngredientDashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('vendorProfile.user')
            ->whereHas('vendorProfile', fn($q) => $q->where('is_verified', true))
            ->where('is_available', true)
            ->where('stock_quantity', '>', 0);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products   = $query->orderBy('name')->paginate(12)->withQueryString();
        $categories = Product::whereHas('vendorProfile', fn($q) => $q->where('is_verified', true))
            ->where('is_available', true)
            ->where('stock_quantity', '>', 0)
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('baker.ingredient_dashboard', compact('products', 'categories'));
    }

    public function bakerDashboard()
    {
        $userId = auth()->id();
        $totalSales      = \App\Models\Sale::where('user_id', $userId)->sum('total');
        $todaySales      = \App\Models\Sale::where('user_id', $userId)->whereDate('sale_date', today())->sum('total');
        $inventoryCount  = \App\Models\BakerInventory::where('user_id', $userId)->count();
        $latestBatch = \App\Models\Recommendation::where('user_id', $userId)
            ->whereNotNull('batch_id')
            ->orderByDesc('created_at')
            ->value('batch_id');

        $recommendations = $latestBatch
            ? \App\Models\Recommendation::where('user_id', $userId)
                ->where('batch_id', $latestBatch)
                ->orderByDesc('score')
                ->take(3)
                ->get()
            : collect();

        return view('baker.dashboard', compact(
            'totalSales', 'todaySales', 'inventoryCount', 'recommendations'
        ));
    }
}