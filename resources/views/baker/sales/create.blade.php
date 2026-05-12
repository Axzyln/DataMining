<x-app-layout>
<x-slot name="header"><h2 class="font-semibold text-xl">Record Sale</h2></x-slot>

<div class="py-8 max-w-xl mx-auto px-6">
    <form method="POST" action="{{ route('baker.sales.store') }}" class="bg-white p-6 rounded shadow space-y-4">
        @csrf
        <div><label class="block font-bold text-sm">Product Name</label>
            <input name="product_name" required class="w-full border rounded p-2" placeholder="e.g. Pandesal, Ensaymada"></div>
        <div class="grid grid-cols-2 gap-3">
            <div><label class="block font-bold text-sm">Quantity Sold</label>
                <input name="quantity_sold" type="number" required class="w-full border rounded p-2"></div>
            <div><label class="block font-bold text-sm">Unit Price (₱)</label>
                <input name="unit_price" type="number" step="0.01" required class="w-full border rounded p-2"></div>
        </div>
        <div><label class="block font-bold text-sm">Sale Date</label>
            <input name="sale_date" type="date" required value="{{ today()->format('Y-m-d') }}" class="w-full border rounded p-2"></div>
        <button class="bg-green-600 text-white px-6 py-2 rounded">Save Sale</button>
    </form>
</div>
</x-app-layout>