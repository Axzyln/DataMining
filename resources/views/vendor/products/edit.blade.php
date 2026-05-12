<x-app-layout>
<x-slot name="header"><h2 class="font-semibold text-xl">Edit Product</h2></x-slot>

<div class="py-8 max-w-2xl mx-auto px-6">
    <form method="POST" action="{{ route('vendor.products.update', $product) }}" class="bg-white p-6 rounded shadow space-y-4">
        @csrf @method('PUT')
        <div><label class="block font-bold text-sm">Name</label>
            <input name="name" required value="{{ old('name', $product->name) }}" class="w-full border rounded p-2"></div>
        <div><label class="block font-bold text-sm">Category</label>
            <input name="category" required value="{{ old('category', $product->category) }}" class="w-full border rounded p-2"></div>
        <div class="grid grid-cols-3 gap-3">
            <div><label class="block font-bold text-sm">Price (₱)</label>
                <input name="price" type="number" step="0.01" required value="{{ old('price', $product->price) }}" class="w-full border rounded p-2"></div>
            <div><label class="block font-bold text-sm">Stock</label>
                <input name="stock_quantity" type="number" required value="{{ old('stock_quantity', $product->stock_quantity) }}" class="w-full border rounded p-2"></div>
            <div><label class="block font-bold text-sm">Unit</label>
                <select name="unit" class="w-full border rounded p-2">
                    @foreach(['kg','g','L','mL','pcs'] as $u)
                        <option @selected($product->unit === $u)>{{ $u }}</option>
                    @endforeach
                </select></div>
        </div>
        <div><label class="block font-bold text-sm">Description</label>
            <textarea name="description" rows="3" class="w-full border rounded p-2">{{ old('description', $product->description) }}</textarea></div>
        <label class="flex items-center"><input type="checkbox" name="is_available" value="1" @checked($product->is_available) class="mr-2"> Available</label>
        <button class="bg-amber-600 text-white px-6 py-2 rounded">Update</button>
    </form>
</div>
</x-app-layout>