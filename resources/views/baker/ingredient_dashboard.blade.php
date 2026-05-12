<x-app-layout>
<x-slot name="header">Find Ingredients</x-slot>

<div class="py-8 max-w-7xl mx-auto px-6">

    {{-- Search bar --}}
    <form method="GET" id="search-form">
        <input type="hidden" name="category" value="{{ request('category') }}">
        <div class="flex gap-3 mb-4">
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 15.803a7.5 7.5 0 0010.607 0z"/>
                </svg>
                <input name="search"
                       value="{{ request('search') }}"
                       placeholder="Search ingredients by name..."
                       class="w-full rounded-lg border border-gray-300 py-2.5 pl-10 pr-4 text-sm focus:border-amber-500 focus:ring-amber-500">
            </div>
            <button type="submit"
                    class="rounded-lg bg-amber-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-amber-700 transition-colors">
                Search
            </button>
            @if(request('search') || request('category'))
                <a href="{{ route('baker.ingredients') }}"
                   class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 transition-colors">
                    Clear
                </a>
            @endif
        </div>
    </form>

    {{-- Category pills --}}
    <div class="flex flex-wrap gap-2 mb-6">
        <a href="{{ route('baker.ingredients', array_merge(request()->except('category', 'page'), [])) }}"
           class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                  {{ !request('category') ? 'bg-amber-600 text-white' : 'bg-white border border-gray-300 text-gray-600 hover:border-amber-400 hover:text-amber-700' }}">
            All
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('baker.ingredients', array_merge(request()->except('category', 'page'), ['category' => $cat])) }}"
               class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                      {{ request('category') === $cat ? 'bg-amber-600 text-white' : 'bg-white border border-gray-300 text-gray-600 hover:border-amber-400 hover:text-amber-700' }}">
                {{ $cat }}
            </a>
        @endforeach
    </div>

    {{-- Result count --}}
    <p class="mb-4 text-sm text-gray-500">
        Showing {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }} of {{ $products->total() }} ingredient{{ $products->total() !== 1 ? 's' : '' }}
        @if(request('search')) for "<span class="font-medium text-gray-700">{{ request('search') }}</span>"@endif
        @if(request('category')) in <span class="font-medium text-gray-700">{{ request('category') }}</span>@endif
    </p>

    {{-- Product grid --}}
    <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @forelse($products as $p)
        <div class="flex flex-col bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
            {{-- Category badge --}}
            <div class="px-4 pt-4">
                <span class="inline-block rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-semibold text-amber-700">
                    {{ $p->category }}
                </span>
            </div>

            {{-- Name & price --}}
            <div class="flex-1 px-4 pt-2 pb-3">
                <h3 class="font-semibold text-gray-900 leading-snug">{{ $p->name }}</h3>
                @if($p->description)
                    <p class="mt-1 text-xs text-gray-500 line-clamp-2">{{ $p->description }}</p>
                @endif
                <div class="mt-3 flex items-baseline gap-1">
                    <span class="text-xl font-bold text-amber-600">₱{{ number_format($p->price, 2) }}</span>
                    <span class="text-sm text-gray-500">/ {{ $p->unit }}</span>
                </div>
                <div class="mt-1 text-xs text-gray-500">
                    {{ $p->stock_quantity }} {{ $p->unit }} available
                </div>
            </div>

            {{-- Vendor --}}
            <div class="border-t border-gray-100 px-4 py-3">
                <div class="flex items-start gap-2">
                    <div class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-stone-100 text-xs font-bold text-stone-600">
                        {{ strtoupper(substr($p->vendorProfile->store_name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <div class="truncate text-sm font-medium text-gray-800">{{ $p->vendorProfile->store_name }}</div>
                        <div class="truncate text-xs text-gray-400">{{ $p->vendorProfile->contact_number }}</div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full rounded-xl border border-dashed border-gray-300 bg-white p-16 text-center">
            <svg class="mx-auto mb-3 h-10 w-10 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 15.803a7.5 7.5 0 0010.607 0z"/>
            </svg>
            <p class="font-medium text-gray-500">No ingredients found</p>
            <p class="mt-1 text-sm text-gray-400">Try a different name or category</p>
            <a href="{{ route('baker.ingredients') }}" class="mt-4 inline-block text-sm text-amber-600 hover:underline">Clear filters</a>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($products->hasPages())
        <div class="mt-8">{{ $products->links() }}</div>
    @endif

</div>
</x-app-layout>
