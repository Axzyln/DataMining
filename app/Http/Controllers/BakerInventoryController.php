<?php
namespace App\Http\Controllers;

use App\Models\BakerInventory;
use Illuminate\Http\Request;

class BakerInventoryController extends Controller
{
    public function index()
    {
        $items = BakerInventory::where('user_id', auth()->id())
            ->orderBy('ingredient_name')->paginate(15);
        return view('baker.inventory.index', compact('items'));
    }

    public function create() { return view('baker.inventory.create'); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ingredient_name' => 'required|string|max:255',
            'quantity'        => 'required|numeric|min:0',
            'unit'            => 'required|string|max:20',
            'reorder_level'   => 'required|numeric|min:0',
        ]);
        $data['user_id'] = auth()->id();
        BakerInventory::create($data);
        return redirect()->route('baker.inventory.index')->with('success', 'Ingredient added.');
    }

    public function edit(BakerInventory $inventory)
    {
        $this->authorizeOwner($inventory);
        return view('baker.inventory.edit', ['item' => $inventory]);
    }

    public function update(Request $request, BakerInventory $inventory)
    {
        $this->authorizeOwner($inventory);
        $data = $request->validate([
            'ingredient_name' => 'required|string|max:255',
            'quantity'        => 'required|numeric|min:0',
            'unit'            => 'required|string|max:20',
            'reorder_level'   => 'required|numeric|min:0',
        ]);
        $inventory->update($data);
        return redirect()->route('baker.inventory.index')->with('success', 'Updated.');
    }

    public function destroy(BakerInventory $inventory)
    {
        $this->authorizeOwner($inventory);
        $inventory->delete();
        return back()->with('success', 'Removed.');
    }

    private function authorizeOwner(BakerInventory $inventory): void
    {
        if ($inventory->user_id !== auth()->id()) abort(403);
    }

    public function show(BakerInventory $inventory) { abort(404); }
}