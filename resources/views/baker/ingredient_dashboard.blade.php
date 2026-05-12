<x-app-layout>
<x-slot name="header"><h2 class="font-semibold text-xl">🛒 Centralized Ingredient Dashboard</h2></x-slot>

<div class="py-8 max-w-7xl mx-auto px-6">
    <form method="GET" class="flex gap-3 mb-6">
        <input name="search" placeholder="Search ingredient..." value="{{ request('search') }}" class="flex-1 border rounded p-2">
        <select name="category" class="border rounded p-2">
            <option value="">All Categories</option>
            @foreach($categories as $c)
                <option value="{{ $c }}" @selected(request('category') === $c)>{{ $c }}</option>
            @endforeach
        </select>
        <button class="bg-amber-600 text-white px-5 py-2 rounded">Search</button>
    </form>

    <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-4">
        @forelse($products as $p)
        <div class="bg-white p-4 rounded shadow">
            <div class="text-xs text-gray-500 uppercase">{{ $p->category }}</div>
            <h3 class="font-bold text-lg">{{ $p->name }}</h3>
            <div class="text-amber-700 text-xl font-bold">₱{{ number_format($p->price,2) }} <span class="text-sm">/ {{ $p->unit }}</span></div>
            <div class="text-sm text-gray-600 mt-1">Stock: {{ $p->stock_quantity }} {{ $p->unit }}</div>
            <div class="border-t mt-3 pt-3 text-sm">
                <div class="font-semibold">🏪 {{ $p->vendorProfile->store_name }}</div>
                <div class="text-gray-500">{{ $p->vendorProfile->address }}</div>
                <div class="text-gray-500">📞 {{ $p->vendorProfile->contact_number }}</div>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white p-10 rounded shadow text-center text-gray-500">
            No ingredients found. Try a different search.
        </div>
        @endforelse
    </div>
    <div class="mt-6">{{ $products->links() }}</div>
</div>
</x-app-layout>