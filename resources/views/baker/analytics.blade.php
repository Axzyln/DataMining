<x-app-layout>
<x-slot name="header"><h2 class="font-semibold text-xl">📊 Analytics Dashboard</h2></x-slot>

<div class="py-8 max-w-7xl mx-auto px-6 space-y-6">
    <div class="grid md:grid-cols-3 gap-4">
        <div class="bg-white p-6 rounded shadow"><div class="text-gray-500">Total Revenue</div><div class="text-3xl font-bold text-green-600">₱{{ number_format($totalRevenue,2) }}</div></div>
        <div class="bg-white p-6 rounded shadow"><div class="text-gray-500">Total Sales Count</div><div class="text-3xl font-bold">{{ $totalSales }}</div></div>
        <div class="bg-white p-6 rounded shadow"><div class="text-gray-500">Low Stock Items</div><div class="text-3xl font-bold text-red-600">{{ $lowStock->count() }}</div></div>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded shadow">
            <h3 class="font-bold mb-3">📈 Revenue Trend (Last 7 Days)</h3>
            <canvas id="trendChart" height="200"></canvas>
        </div>
        <div class="bg-white p-6 rounded shadow">
            <h3 class="font-bold mb-3">🏆 Top Selling Products</h3>
            <canvas id="topChart" height="200"></canvas>
        </div>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h3 class="font-bold mb-3">⚠️ Low Stock Alerts</h3>
        @forelse($lowStock as $item)
            <div class="flex justify-between border-b py-2">
                <span>{{ $item->ingredient_name }}</span>
                <span class="text-red-600">{{ $item->quantity }} {{ $item->unit }} (reorder at {{ $item->reorder_level }})</span>
            </div>
        @empty
            <p class="text-gray-500">All ingredients are above reorder level. ✅</p>
        @endforelse
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('trendChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($trend->pluck('date')) !!},
        datasets: [{
            label: 'Revenue (₱)',
            data: {!! json_encode($trend->pluck('revenue')) !!},
            borderColor: '#d97706',
            backgroundColor: 'rgba(217, 119, 6, 0.1)',
            tension: 0.3, fill: true
        }]
    }
});

new Chart(document.getElementById('topChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($topProducts->pluck('product_name')) !!},
        datasets: [{
            label: 'Quantity Sold',
            data: {!! json_encode($topProducts->pluck('total_qty')) !!},
            backgroundColor: '#d97706'
        }]
    }
});
</script>
</x-app-layout>