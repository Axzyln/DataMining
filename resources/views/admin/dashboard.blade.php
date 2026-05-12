<x-app-layout>
<x-slot name="header"><h2 class="font-semibold text-xl">Admin Dashboard</h2></x-slot>

<div class="py-8 max-w-7xl mx-auto px-6 space-y-6">
    <div class="grid md:grid-cols-3 gap-4">
        <div class="bg-white p-6 rounded-lg shadow"><div class="text-gray-500">Total Users</div><div class="text-3xl font-bold">{{ $totalUsers }}</div></div>
        <div class="bg-white p-6 rounded-lg shadow"><div class="text-gray-500">Vendors</div><div class="text-3xl font-bold">{{ $totalVendors }}</div></div>
        <div class="bg-white p-6 rounded-lg shadow"><div class="text-gray-500">Bakers</div><div class="text-3xl font-bold">{{ $totalBakers }}</div></div>
        <div class="bg-white p-6 rounded-lg shadow"><div class="text-gray-500">Products Listed</div><div class="text-3xl font-bold">{{ $totalProducts }}</div></div>
        <div class="bg-white p-6 rounded-lg shadow"><div class="text-gray-500">Pending Vendors</div><div class="text-3xl font-bold text-orange-600">{{ $pendingVendors }}</div></div>
        <div class="bg-white p-6 rounded-lg shadow"><div class="text-gray-500">Total Sales</div><div class="text-3xl font-bold">₱{{ number_format($totalSales,2) }}</div></div>
    </div>

    <div class="flex gap-3">
        <a href="{{ route('admin.vendors') }}" class="bg-amber-600 text-white px-5 py-2 rounded">Manage Vendors</a>
        <a href="{{ route('admin.users') }}" class="bg-gray-700 text-white px-5 py-2 rounded">Manage Users</a>
    </div>
</div>
</x-app-layout>