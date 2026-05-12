<x-app-layout>
<x-slot name="header"><h2 class="font-semibold text-xl">Vendor Dashboard</h2></x-slot>

<div class="py-8 max-w-7xl mx-auto px-6 space-y-6">
    @if(!$profile)
        <div class="bg-yellow-100 border border-yellow-400 p-4 rounded">
            ⚠️ You haven't set up your store profile yet.
            <a href="{{ route('vendor.profile.edit') }}" class="underline font-bold">Set it up now</a>
        </div>
    @elseif(!$profile->is_verified)
        <div class="bg-orange-100 border border-orange-400 p-4 rounded">
            ⏳ Your profile is pending admin verification. Products will appear publicly only after verification.
        </div>
    @endif

    <div class="grid md:grid-cols-3 gap-4">
        <div class="bg-white p-6 rounded shadow">
            <div class="text-gray-500">Store Name</div>
            <div class="text-xl font-bold">{{ $profile->store_name ?? '— not set —' }}</div>
        </div>
        <div class="bg-white p-6 rounded shadow">
            <div class="text-gray-500">Products Listed</div>
            <div class="text-3xl font-bold text-amber-700">{{ $productCount }}</div>
        </div>
        <div class="bg-white p-6 rounded shadow">
            <div class="text-gray-500">Low Stock Items</div>
            <div class="text-3xl font-bold text-red-600">{{ $lowStock }}</div>
        </div>
    </div>

    <div class="flex gap-3">
        <a href="{{ route('vendor.profile.edit') }}" class="bg-gray-700 text-white px-5 py-2 rounded">Edit Profile</a>
        <a href="{{ route('vendor.products.index') }}" class="bg-amber-600 text-white px-5 py-2 rounded">My Products</a>
    </div>
</div>
</x-app-layout>