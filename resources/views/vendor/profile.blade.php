<x-app-layout>
<x-slot name="header"><h2 class="font-semibold text-xl">Store Profile</h2></x-slot>

<div class="py-8 max-w-3xl mx-auto px-6">
    @if(session('success'))<div class="bg-green-100 p-3 mb-4 rounded">{{ session('success') }}</div>@endif

    <form method="POST" action="{{ route('vendor.profile.update') }}" class="bg-white p-6 rounded shadow space-y-4">
        @csrf
        <div><label class="block text-sm font-bold">Store Name</label>
            <input name="store_name" required class="w-full border rounded p-2"
                   value="{{ old('store_name', $profile->store_name ?? '') }}"></div>
        <div><label class="block text-sm font-bold">Address</label>
            <input name="address" required class="w-full border rounded p-2"
                   value="{{ old('address', $profile->address ?? '') }}"></div>
        <div><label class="block text-sm font-bold">Contact Number</label>
            <input name="contact_number" required class="w-full border rounded p-2"
                   value="{{ old('contact_number', $profile->contact_number ?? '') }}"></div>
        <div><label class="block text-sm font-bold">Description</label>
            <textarea name="description" rows="3" class="w-full border rounded p-2">{{ old('description', $profile->description ?? '') }}</textarea></div>
        <div class="grid grid-cols-2 gap-3">
            <div><label class="block text-sm font-bold">Latitude (optional)</label>
                <input name="latitude" type="number" step="any" class="w-full border rounded p-2"
                       value="{{ old('latitude', $profile->latitude ?? '') }}"></div>
            <div><label class="block text-sm font-bold">Longitude (optional)</label>
                <input name="longitude" type="number" step="any" class="w-full border rounded p-2"
                       value="{{ old('longitude', $profile->longitude ?? '') }}"></div>
        </div>
        <button class="bg-amber-600 text-white px-6 py-2 rounded">Save Profile</button>
    </form>
</div>
</x-app-layout>