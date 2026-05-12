<x-app-layout>
<x-slot name="header"><h2 class="font-semibold text-xl">Vendors</h2></x-slot>

<div class="py-8 max-w-7xl mx-auto px-6">
    @if(session('success'))<div class="bg-green-100 p-3 mb-4 rounded">{{ session('success') }}</div>@endif

    <table class="w-full bg-white shadow rounded">
        <thead class="bg-amber-100"><tr>
            <th class="p-3 text-left">Store</th><th class="p-3 text-left">Owner</th>
            <th class="p-3 text-left">Address</th><th class="p-3">Status</th><th class="p-3">Action</th>
        </tr></thead>
        <tbody>
        @foreach($vendors as $v)
        <tr class="border-t">
            <td class="p-3">{{ $v->store_name }}</td>
            <td class="p-3">{{ $v->user->name }}</td>
            <td class="p-3">{{ $v->address }}</td>
            <td class="p-3 text-center">
                @if($v->is_verified)<span class="bg-green-100 text-green-700 px-2 py-1 rounded">Verified</span>
                @else<span class="bg-orange-100 text-orange-700 px-2 py-1 rounded">Pending</span>@endif
            </td>
            <td class="p-3 text-center">
                @if(!$v->is_verified)
                <form method="POST" action="{{ route('admin.vendors.verify', $v) }}">
                    @csrf
                    <button class="bg-green-600 text-white px-3 py-1 rounded">Verify</button>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <div class="mt-4">{{ $vendors->links() }}</div>
</div>
</x-app-layout>