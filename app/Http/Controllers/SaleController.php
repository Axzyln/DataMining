<?php
namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::where('user_id', auth()->id())
            ->orderBy('sale_date', 'desc')->paginate(15);
        return view('baker.sales.index', compact('sales'));
    }

    public function create() { return view('baker.sales.create'); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_name'  => 'required|string|max:255',
            'quantity_sold' => 'required|integer|min:1',
            'unit_price'    => 'required|numeric|min:0',
            'sale_date'     => 'required|date',
        ]);

        $data['user_id'] = auth()->id();
        $data['total']   = $data['quantity_sold'] * $data['unit_price'];

        Sale::create($data);
        return redirect()->route('baker.sales.index')->with('success', 'Sale recorded.');
    }

    public function destroy(Sale $sale)
    {
        if ($sale->user_id !== auth()->id()) abort(403);
        $sale->delete();
        return back()->with('success', 'Sale deleted.');
    }

    public function show(Sale $sale) { abort(404); }
    public function edit(Sale $sale) { abort(404); }
    public function update(Request $request, Sale $sale) { abort(404); }
}