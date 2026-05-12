<x-app-layout>
<x-slot name="header"><h2 class="font-semibold text-xl">🤖 AI Product Recommendations</h2></x-slot>

<div class="py-8 max-w-5xl mx-auto px-6 space-y-6">
    @if(session('success'))<div class="bg-green-100 p-3 rounded">{{ session('success') }}</div>@endif

    <div class="bg-amber-50 border border-amber-300 p-4 rounded">
        <p class="text-sm">
            The AI engine analyzes your <b>available ingredients</b> and <b>historical sales</b>
            to recommend bakery products with the highest selling potential.
        </p>
        <form method="POST" action="{{ route('baker.recommendations.generate') }}" class="mt-3">
            @csrf
            <button class="bg-amber-600 text-white px-6 py-2 rounded">⚡ Generate Recommendations</button>
        </form>
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        @forelse($recommendations as $r)
        <div class="bg-white p-6 rounded shadow border-l-4 {{ $r->score >= 70 ? 'border-green-500' : ($r->score >= 40 ? 'border-amber-500' : 'border-gray-300') }}">
            <div class="flex justify-between">
                <h3 class="text-xl font-bold">{{ $r->product_name }}</h3>
                <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded font-bold">{{ $r->score }}%</span>
            </div>
            <p class="text-gray-600 text-sm mt-2">{{ $r->reason }}</p>
            <div class="mt-3 text-xs text-gray-500">
                <b>Required ingredients:</b> {{ implode(', ', $r->required_ingredients ?? []) }}
            </div>
        </div>
        @empty
        <div class="col-span-2 bg-white p-10 rounded shadow text-center text-gray-500">
            No recommendations yet. Click <b>Generate Recommendations</b> above.
        </div>
        @endforelse
    </div>
</div>
</x-app-layout>