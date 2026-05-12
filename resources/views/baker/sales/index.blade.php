<x-app-layout>
<x-slot name="header"><h2 class="font-semibold text-xl">Sales Records</h2></x-slot>

<div class="py-8 max-w-6xl mx-auto px-6">
    @if(session('success'))<div class="bg-green-100 p-3 mb-4 rounded">{{ session('success') }}</div>@endif

    <a href="{{ route('baker.sales.create') }}" class="bg-green-600 text-white px-5 py-2 rounded inline-block mb-4">+ Record Sale</a>

    <table class="w-full bg-white shadow rounded">
        <thead class="bg-amber-100"><tr>
            <th class="p-3 text-left">Date</th><th class="p-3 text-left">Product</th>
            <th class="p-3">Qty</th><th class="p-3">Unit Price</th>
            <th class="p-3">Total</th><th class="p-3"></th>
        </tr></thead>
        <tbody>
        @forelse($sales as $s)
        <tr class="border-t">
            <td class="p-3">{{ $s->sale_date->format('M d, Y') }}</td>
            <td class="p-3">{{ $s->product_name }}</td>
            <td class="p-3 text-center">{{ $s->quantity_sold }}</td>
            <td class="p-3 text-center">₱{{ number_format($s->unit_price,2) }}</td>
            <td class="p-3 text-center font-bold">₱{{ number_format($s->total,2) }}</td>
            <td class="p-3 text-center">
                <form method="POST" action="{{ route('baker.sales.destroy', $s) }}" onsubmit="return confirm('Delete?')">
                    @csrf @method('DELETE')
                    <button class="text-red-600">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" class="p-6 text-center text-gray-500">No sales recorded yet.</td></tr>
        @endforelse
        </tbody>
    </table>
    <div class="mt-4">{{ $sales->links() }}</div>
</div>
</x-app-layout>