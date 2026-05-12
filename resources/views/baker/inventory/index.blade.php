<x-app-layout>
<x-slot name="header"><h2 class="font-semibold text-xl">My Ingredient Inventory</h2></x-slot>

<div class="py-8 max-w-5xl mx-auto px-6">
    @if(session('success'))<div class="bg-green-100 p-3 mb-4 rounded">{{ session('success') }}</div>@endif

    <a href="{{ route('baker.inventory.create') }}" class="bg-amber-600 text-white px-5 py-2 rounded inline-block mb-4">+ Add Ingredient</a>

    <table class="w-full bg-white shadow rounded">
        <thead class="bg-amber-100"><tr>
            <th class="p-3 text-left">Ingredient</th>
            <th class="p-3">Quantity</th><th class="p-3">Reorder Level</th>
            <th class="p-3">Status</th><th class="p-3">Actions</th>
        </tr></thead>
        <tbody>
        @forelse($items as $i)
        <tr class="border-t">
            <td class="p-3">{{ $i->ingredient_name }}</td>
            <td class="p-3 text-center">{{ $i->quantity }} {{ $i->unit }}</td>
            <td class="p-3 text-center">{{ $i->reorder_level }} {{ $i->unit }}</td>
            <td class="p-3 text-center">
                @if($i->quantity <= 0)
                    <span class="bg-red-200 text-red-800 px-2 py-1 rounded font-semibold">Out of Stock</span>
                @elseif($i->quantity <= $i->reorder_level)
                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded">Low Stock</span>
                @else
                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded">OK</span>
                @endif
            </td>
            <td class="p-3 text-center space-x-2">
                <a href="{{ route('baker.inventory.edit', $i) }}" class="text-blue-600">Edit</a>
                <form method="POST" action="{{ route('baker.inventory.destroy', $i) }}" class="inline" onsubmit="return confirm('Remove?')">
                    @csrf @method('DELETE')
                    <button class="text-red-600">Remove</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="5" class="p-6 text-center text-gray-500">No ingredients yet.</td></tr>
        @endforelse
        </tbody>
    </table>
    <div class="mt-4">{{ $items->links() }}</div>
</div>
</x-app-layout>
