<x-app-layout>
<x-slot name="header"><h2 class="font-semibold text-xl">Add Product</h2></x-slot>

<div class="py-8 max-w-2xl mx-auto px-6">
    <form method="POST" action="{{ route('vendor.products.store') }}" class="bg-white p-6 rounded shadow space-y-4">
        @csrf
        <div><label class="block font-bold text-sm">Name</label>
            <input name="name" required class="w-full border rounded p-2"></div>
        <div><label class="block font-bold text-sm">Category</label>
            <input name="category" required placeholder="e.g. Flour, Sugar, Dairy" class="w-full border rounded p-2"></div>
        <div class="grid grid-cols-3 gap-3">
            <div><label class="block font-bold text-sm">Price (₱)</label>
                <input name="price" type="number" step="0.01" required class="w-full border rounded p-2"></div>
            <div><label class="block font-bold text-sm">Stock</label>
                <input name="stock_quantity" type="number" required class="w-full border rounded p-2"></div>
            <div><label class="block font-bold text-sm">Unit</label>
                <select name="unit" class="w-full border rounded p-2">
                    <option>kg</option><option>g</option><option>L</option><option>mL</option><option>pcs</option>
                </select></div>
        </div>
        <div><label class="block font-bold text-sm">Description</label>
            <textarea name="description" rows="3" class="w-full border rounded p-2"></textarea></div>
        <button class="bg-amber-600 text-white px-6 py-2 rounded">Save</button>
    </form>
</div>
</x-app-layout>