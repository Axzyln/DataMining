<?php
namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\BakerInventory;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // DESCRIPTIVE: top selling products
        $topProducts = Sale::where('user_id', $userId)
            ->select('product_name',
                DB::raw('SUM(quantity_sold) as total_qty'),
                DB::raw('SUM(total) as total_revenue'))
            ->groupBy('product_name')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        // TREND: last 7 days revenue
        $trend = Sale::where('user_id', $userId)
            ->where('sale_date', '>=', now()->subDays(7))
            ->select(DB::raw('DATE(sale_date) as date'),
                     DB::raw('SUM(total) as revenue'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // INVENTORY: items below reorder level
        $lowStock = BakerInventory::where('user_id', $userId)
            ->whereColumn('quantity', '<=', 'reorder_level')
            ->get();

        $totalRevenue = Sale::where('user_id', $userId)->sum('total');
        $totalSales   = Sale::where('user_id', $userId)->count();

        return view('baker.analytics', compact(
            'topProducts', 'trend', 'lowStock', 'totalRevenue', 'totalSales'
        ));
    }
}