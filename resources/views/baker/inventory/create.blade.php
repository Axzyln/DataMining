<x-app-layout>
<x-slot name="header"><h2 class="font-semibold text-xl">Add Ingredient</h2></x-slot>

<div class="py-8 max-w-xl mx-auto px-6">
    <form method="POST" action="{{ route('baker.inventory.store') }}" class="bg-white p-6 rounded shadow space-y-4">
        @csrf
        <div><label class="block font-bold text-sm">Ingredient Name</label>
            <input name="ingredient_name" required class="w-full border rounded p-2" placeholder="e.g. Flour, Sugar, Yeast"></div>
        <div class="grid grid-cols-3 gap-3">
            <div><label class="block font-bold text-sm">Quantity</label>
                <input name="quantity" type="number" step="0.01" required class="w-full border rounded p-2"></div>
            <div><label class="block font-bold text-sm">Unit</label>
                <select name="unit" class="w-full border rounded p-2">
                    <option>kg</option><option>g</option><option>L</option><option>mL</option><option>pcs</option>
                </select></div>
            <div><label class="block font-bold text-sm">Reorder Level</label>
                <input name="reorder_level" type="number" step="0.01" required class="w-full border rounded p-2"></div>
        </div>
        <button class="bg-amber-600 text-white px-6 py-2 rounded">Save</button>
    </form>
</div>
</x-app-layout>
