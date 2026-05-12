<x-app-layout>
<x-slot name="header">{{ $vendor->store_name }}</x-slot>

<div class="py-8 max-w-7xl mx-auto px-6 space-y-6">

    <a href="{{ route('baker.vendors') }}"
       class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
        </svg>
        Back to Vendors
    </a>

    {{-- Vendor header card --}}
    <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-6">
        <div class="flex items-start gap-5">
            <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-blue-100 text-2xl font-bold text-blue-700">
                {{ strtoupper(substr($vendor->store_name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-3 flex-wrap">
                    <h1 class="text-xl font-bold text-gray-900">{{ $vendor->store_name }}</h1>
                    <span class="inline-flex items-center gap-1 rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-semibold text-blue-700">
                        Verified Vendor
                    </span>
                </div>

                @if($vendor->description)
                    <p class="mt-2 text-sm text-gray-600">{{ $vendor->description }}</p>
                @endif

                <div class="mt-4 flex flex-wrap gap-4">
                    @if($vendor->address)
                        <div class="flex items-center gap-1.5 text-sm text-gray-500">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                            </svg>
                            {{ $vendor->address }}
                        </div>
                    @endif
                    @if($vendor->contact_number)
                        <div class="flex items-center gap-1.5 text-sm text-gray-500">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                            </svg>
                            {{ $vendor->contact_number }}
                        </div>
                    @endif
                    @if($vendor->user?->email)
                        <div class="flex items-center gap-1.5 text-sm text-gray-500">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                            </svg>
                            {{ $vendor->user->email }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- Message vendor button --}}
            <a href="{{ route('messages.compose', ['to' => $vendor->user_id, 'subject' => 'Inquiry about ' . $vendor->store_name]) }}"
               class="shrink-0 inline-flex items-center gap-2 rounded-lg bg-amber-600 px-4 py-2 text-sm font-medium text-white hover:bg-amber-700 transition-colors">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                </svg>
                Message Vendor
            </a>
        </div>
    </div>

    {{-- Products by category --}}
    @if($products->isEmpty())
        <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-10 text-center">
            <p class="text-sm text-gray-400">This vendor has no available products at the moment.</p>
        </div>
    @else
        @foreach($products as $category => $items)
        <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-6">
            <h2 class="mb-4 text-sm font-semibold text-gray-700 flex items-center gap-2">
                <span class="inline-block h-2 w-2 rounded-full bg-amber-500"></span>
                {{ $category }}
                <span class="ml-1 text-xs text-gray-400 font-normal">({{ $items->count() }})</span>
            </h2>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($items as $product)
                <div class="rounded-lg border border-gray-100 bg-gray-50 p-4">
                    <div class="font-medium text-gray-900 text-sm">{{ $product->name }}</div>
                    @if($product->description)
                        <p class="mt-1 text-xs text-gray-500 line-clamp-2">{{ $product->description }}</p>
                    @endif
                    <div class="mt-3 flex items-center justify-between">
                        <div class="text-sm font-bold text-amber-600">₱{{ number_format($product->price, 2) }} / {{ $product->unit }}</div>
                        <div class="text-xs text-gray-400">{{ number_format($product->stock_quantity) }} in stock</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    @endif

</div>
</x-app-layout>
