<x-app-layout>
<x-slot name="header"><h2 class="font-semibold text-xl">Baker Dashboard</h2></x-slot>

<div class="py-8 max-w-7xl mx-auto px-6 space-y-6">
    <div class="grid md:grid-cols-3 gap-4">
        <div class="bg-white p-6 rounded shadow"><div class="text-gray-500">Today's Sales</div><div class="text-3xl font-bold text-green-600">₱{{ number_format($todaySales,2) }}</div></div>
        <div class="bg-white p-6 rounded shadow"><div class="text-gray-500">Total Sales</div><div class="text-3xl font-bold">₱{{ number_format($totalSales,2) }}</div></div>
        <div class="bg-white p-6 rounded shadow"><div class="text-gray-500">Inventory Items</div><div class="text-3xl font-bold">{{ $inventoryCount }}</div></div>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded shadow">
            <h3 class="font-bold mb-3">Quick Actions</h3>
            <div class="space-y-2">
                <a href="{{ route('baker.ingredients') }}" class="block bg-amber-600 text-white px-4 py-2 rounded text-center">🛒 Find Ingredients</a>
                <a href="{{ route('baker.sales.create') }}" class="block bg-green-600 text-white px-4 py-2 rounded text-center">💰 Record Sale</a>
                <a href="{{ route('baker.analytics') }}" class="block bg-blue-600 text-white px-4 py-2 rounded text-center">📊 View Analytics</a>
            </div>
        </div>
        <div class="bg-white p-6 rounded shadow">
            <h3 class="font-bold mb-3">🤖 Top AI Recommendations</h3>
            @forelse($recommendations as $r)
                <div class="border-b py-2">
                    <div class="font-semibold">{{ $r->product_name }} <span class="text-amber-600">({{ $r->score }}%)</span></div>
                    <div class="text-sm text-gray-600">{{ $r->reason }}</div>
                </div>
            @empty
                <p class="text-gray-500">No recommendations yet.
                    <a href="{{ route('baker.recommendations.index') }}" class="underline">Generate now</a>
                </p>
            @endforelse
        </div>
    </div>
</div>
</x-app-layout>