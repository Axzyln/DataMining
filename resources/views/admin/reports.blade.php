<x-app-layout>
<x-slot name="header">Operational Reports</x-slot>

<div class="py-8 max-w-7xl mx-auto px-6 space-y-6">

    {{-- Flash --}}
    @if(session('success'))
        <div class="flex items-center gap-3 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <p class="text-sm text-gray-500">Download data exports as CSV files. All data reflects current database state.</p>

    <div class="grid md:grid-cols-3 gap-6">

        {{-- Sales Report --}}
        <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-6 flex flex-col gap-4">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-amber-100">
                    <svg class="h-5 w-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75"/>
                    </svg>
                </div>
                <div>
                    <div class="font-semibold text-gray-800">Sales Report</div>
                    <div class="text-xs text-gray-400">{{ number_format($salesCount) }} records</div>
                </div>
            </div>
            <p class="text-sm text-gray-500">Includes baker name, product, quantity sold, unit price, total, and sale date.</p>
            <a href="{{ route('admin.reports.sales') }}"
               class="mt-auto inline-flex items-center justify-center gap-2 rounded-lg bg-amber-600 px-4 py-2 text-sm font-medium text-white hover:bg-amber-700 transition-colors">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                </svg>
                Download Sales CSV
            </a>
        </div>

        {{-- Users Report --}}
        <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-6 flex flex-col gap-4">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100">
                    <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="font-semibold text-gray-800">Users Report</div>
                    <div class="text-xs text-gray-400">{{ number_format($usersCount) }} records</div>
                </div>
            </div>
            <p class="text-sm text-gray-500">Includes name, email, role, verification status, registration date, and last login.</p>
            <a href="{{ route('admin.reports.users') }}"
               class="mt-auto inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 transition-colors">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                </svg>
                Download Users CSV
            </a>
        </div>

        {{-- AI Recommendations Report --}}
        <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-6 flex flex-col gap-4">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-purple-100">
                    <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                    </svg>
                </div>
                <div>
                    <div class="font-semibold text-gray-800">AI Recommendations</div>
                    <div class="text-xs text-gray-400">{{ number_format($recsCount) }} records</div>
                </div>
            </div>
            <p class="text-sm text-gray-500">Includes baker, product recommended, AI score, baker feedback, and generation timestamp.</p>
            <a href="{{ route('admin.reports.recommendations') }}"
               class="mt-auto inline-flex items-center justify-center gap-2 rounded-lg bg-purple-600 px-4 py-2 text-sm font-medium text-white hover:bg-purple-700 transition-colors">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                </svg>
                Download AI Report CSV
            </a>
        </div>

    </div>
</div>
</x-app-layout>
