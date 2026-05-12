<x-app-layout>
<x-slot name="header"><h2 class="font-semibold text-xl">Edit Ingredient</h2></x-slot>

<div class="py-8 max-w-xl mx-auto px-6">
    <form method="POST" action="{{ route('baker.inventory.update', $item) }}" class="bg-white p-6 rounded shadow space-y-4">
        @csrf @method('PUT')
        <div><label class="block font-bold text-sm">Ingredient Name</label>
            <input name="ingredient_name" required value="{{ $item->ingredient_name }}" class="w-full border rounded p-2"></div>
        <div class="grid grid-cols-3 gap-3">
            <div><label class="block font-bold text-sm">Quantity</label>
                <input name="quantity" type="number" step="0.01" required value="{{ $item->quantity }}" class="w-full border rounded p-2"></div>
            <div><label class="block font-bold text-sm">Unit</label>
                <select name="unit" class="w-full border rounded p-2">
                    @foreach(['kg','g','L','mL','pcs'] as $u)
                        <option @selected($item->unit === $u)>{{ $u }}</option>
                    @endforeach
                </select></div>
            <div><label class="block font-bold text-sm">Reorder Level</label>
                <input name="reorder_level" type="number" step="0.01" required value="{{ $item->reorder_level }}" class="w-full border rounded p-2"></div>
        </div>
        <button class="bg-amber-600 text-white px-6 py-2 rounded">Update</button>
    </form>
</div>
</x-app-layout>