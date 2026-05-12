<x-app-layout>
<x-slot name="header">Browse Vendors</x-slot>

<div class="py-8 max-w-7xl mx-auto px-6">

    <p class="mb-6 text-sm text-gray-500">{{ $vendors->total() }} verified vendor{{ $vendors->total() !== 1 ? 's' : '' }} available</p>

    @if($vendors->isEmpty())
        <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-12 text-center">
            <p class="text-gray-400">No verified vendors yet. Check back soon.</p>
        </div>
    @else
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($vendors as $vendor)
        <a href="{{ route('baker.vendors.show', $vendor) }}"
           class="rounded-xl bg-white border border-gray-200 shadow-sm p-5 hover:border-amber-300 hover:shadow-md transition-all flex flex-col gap-3">

            {{-- Header --}}
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-blue-100 text-sm font-bold text-blue-700">
                    {{ strtoupper(substr($vendor->store_name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <div class="font-semibold text-gray-900 truncate">{{ $vendor->store_name }}</div>
                    <div class="text-xs text-blue-600 font-medium">Verified Vendor</div>
                </div>
            </div>

            {{-- Description --}}
            @if($vendor->description)
                <p class="text-sm text-gray-500 line-clamp-2">{{ $vendor->description }}</p>
            @endif

            {{-- Meta --}}
            <div class="mt-auto space-y-1.5">
                @if($vendor->address)
                    <div class="flex items-center gap-1.5 text-xs text-gray-400">
                        <svg class="h-3.5 w-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                        </svg>
                        <span class="truncate">{{ $vendor->address }}</span>
                    </div>
                @endif
                @if($vendor->contact_number)
                    <div class="flex items-center gap-1.5 text-xs text-gray-400">
                        <svg class="h-3.5 w-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                        </svg>
                        {{ $vendor->contact_number }}
                    </div>
                @endif
                <div class="flex items-center gap-1.5 text-xs text-gray-400">
                    <svg class="h-3.5 w-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>
                    </svg>
                    {{ $vendor->products_count }} product{{ $vendor->products_count !== 1 ? 's' : '' }}
                </div>
            </div>

            <div class="text-xs font-medium text-amber-600">View Profile →</div>
        </a>
        @endforeach
    </div>

    <div class="mt-6">{{ $vendors->links() }}</div>
    @endif

</div>
</x-app-layout>
