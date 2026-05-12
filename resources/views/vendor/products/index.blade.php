<x-app-layout>
<x-slot name="header"><h2 class="font-semibold text-xl">My Products</h2></x-slot>

<div class="py-8 max-w-7xl mx-auto px-6">
    @if(session('success'))<div class="bg-green-100 p-3 mb-4 rounded">{{ session('success') }}</div>@endif

    <a href="{{ route('vendor.products.create') }}" class="bg-amber-600 text-white px-5 py-2 rounded inline-block mb-4">+ Add Product</a>

    <table class="w-full bg-white shadow rounded">
        <thead class="bg-amber-100"><tr>
            <th class="p-3 text-left">Name</th><th class="p-3">Category</th>
            <th class="p-3">Price</th><th class="p-3">Stock</th><th class="p-3">Actions</th>
        </tr></thead>
        <tbody>
        @forelse($products as $p)
        <tr class="border-t">
            <td class="p-3">{{ $p->name }}</td>
            <td class="p-3 text-center">{{ $p->category }}</td>
            <td class="p-3 text-center">₱{{ number_format($p->price,2) }}</td>
            <td class="p-3 text-center">{{ $p->stock_quantity }} {{ $p->unit }}</td>
            <td class="p-3 text-center space-x-2">
                <a href="{{ route('vendor.products.edit', $p) }}" class="text-blue-600">Edit</a>
                <form method="POST" action="{{ route('vendor.products.destroy', $p) }}" class="inline" onsubmit="return confirm('Delete?')">
                    @csrf @method('DELETE')
                    <button class="text-red-600">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="5" class="p-6 text-center text-gray-500">No products yet.</td></tr>
        @endforelse
        </tbody>
    </table>
    <div class="mt-4">{{ $products->links() }}</div>
</div>
</x-app-layout>