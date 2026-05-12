<x-app-layout>
<x-slot name="header">Admin Dashboard</x-slot>

<div class="py-8 max-w-7xl mx-auto px-6 space-y-8">

    {{-- ── Stat cards ──────────────────────────────────────────────────── --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-5">
            <div class="text-xs font-semibold uppercase tracking-wide text-gray-400">Total Users</div>
            <div class="mt-1 text-3xl font-bold text-gray-900">{{ $totalUsers }}</div>
            @if($newThisWeek)
                <div class="mt-1 text-xs text-green-600">+{{ $newThisWeek }} this week</div>
            @endif
        </div>
        <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-5">
            <div class="text-xs font-semibold uppercase tracking-wide text-gray-400">Active (7 days)</div>
            <div class="mt-1 text-3xl font-bold text-green-600">{{ $activeUsers }}</div>
            <div class="mt-1 text-xs text-gray-400">logged in recently</div>
        </div>
        <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-5">
            <div class="text-xs font-semibold uppercase tracking-wide text-gray-400">Vendors</div>
            <div class="mt-1 text-3xl font-bold text-blue-600">{{ $totalVendors }}</div>
            @if($pendingVendors)
                <div class="mt-1 text-xs text-orange-500">{{ $pendingVendors }} pending verification</div>
            @else
                <div class="mt-1 text-xs text-gray-400">all verified</div>
            @endif
        </div>
        <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-5">
            <div class="text-xs font-semibold uppercase tracking-wide text-gray-400">Bakers</div>
            <div class="mt-1 text-3xl font-bold text-amber-600">{{ $totalBakers }}</div>
            <div class="mt-1 text-xs text-gray-400">registered bakers</div>
        </div>
        <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-5">
            <div class="text-xs font-semibold uppercase tracking-wide text-gray-400">Total Revenue</div>
            <div class="mt-1 text-3xl font-bold text-gray-900">₱{{ number_format($totalRevenue, 0) }}</div>
            <div class="mt-1 text-xs text-gray-400">all-time sales</div>
        </div>
        <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-5">
            <div class="text-xs font-semibold uppercase tracking-wide text-gray-400">Products Listed</div>
            <div class="mt-1 text-3xl font-bold text-gray-900">{{ $totalProducts }}</div>
            <div class="mt-1 text-xs text-gray-400">across all vendors</div>
        </div>
        <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-5 col-span-2">
            <div class="text-xs font-semibold uppercase tracking-wide text-gray-400">Quick Actions</div>
            <div class="mt-3 flex flex-wrap gap-2">
                <a href="{{ route('admin.users.create') }}" class="rounded-lg bg-amber-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-amber-700 transition-colors">+ Add User</a>
                <a href="{{ route('admin.vendors') }}" class="rounded-lg bg-blue-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-blue-700 transition-colors">Manage Vendors</a>
                <a href="{{ route('admin.users') }}" class="rounded-lg bg-gray-700 px-3 py-1.5 text-xs font-medium text-white hover:bg-gray-800 transition-colors">Manage Users</a>
            </div>
        </div>
    </div>

    {{-- ── Sales trend chart ────────────────────────────────────────────── --}}
    <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-6">
        <h2 class="mb-4 text-sm font-semibold text-gray-700">Revenue — Last 14 Days</h2>
        <div class="relative h-56">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    {{-- ── Top products + Category breakdown ───────────────────────────── --}}
    <div class="grid md:grid-cols-2 gap-6">

        {{-- Top products --}}
        <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-6">
            <h2 class="mb-4 text-sm font-semibold text-gray-700">Top 5 Products by Revenue</h2>
            @php $maxRev = $topProducts->max('revenue') ?: 1; @endphp
            <div class="space-y-3">
                @forelse($topProducts as $p)
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-medium text-gray-800">{{ $p->product_name }}</span>
                        <span class="text-gray-500">₱{{ number_format($p->revenue, 0) }}</span>
                    </div>
                    <div class="h-2 rounded-full bg-gray-100">
                        <div class="h-2 rounded-full bg-amber-500"
                             style="width: {{ round(($p->revenue / $maxRev) * 100) }}%"></div>
                    </div>
                    <div class="mt-0.5 text-xs text-gray-400">{{ number_format($p->total_qty) }} units sold</div>
                </div>
                @empty
                    <p class="text-sm text-gray-400">No sales recorded yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Products by category --}}
        <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-6">
            <h2 class="mb-4 text-sm font-semibold text-gray-700">Products by Category</h2>
            <div class="relative h-52 flex items-center justify-center">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>

    </div>

    {{-- ── Top bakers + Recent logins ───────────────────────────────────── --}}
    <div class="grid md:grid-cols-2 gap-6">

        {{-- Top bakers --}}
        <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-6">
            <h2 class="mb-4 text-sm font-semibold text-gray-700">Top Bakers by Revenue</h2>
            @php $maxBaker = $topBakers->max('revenue') ?: 1; @endphp
            <div class="space-y-3">
                @forelse($topBakers as $b)
                <div class="flex items-center gap-3">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-amber-100 text-xs font-bold text-amber-700">
                        {{ strtoupper(substr($b->user?->name ?? '?', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between text-sm">
                            <span class="font-medium text-gray-800 truncate">{{ $b->user?->name ?? 'Unknown' }}</span>
                            <span class="ml-2 shrink-0 text-gray-500">₱{{ number_format($b->revenue, 0) }}</span>
                        </div>
                        <div class="mt-1 h-1.5 rounded-full bg-gray-100">
                            <div class="h-1.5 rounded-full bg-amber-400"
                                 style="width: {{ round(($b->revenue / $maxBaker) * 100) }}%"></div>
                        </div>
                    </div>
                </div>
                @empty
                    <p class="text-sm text-gray-400">No sales recorded yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Recent logins --}}
        <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-6">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-sm font-semibold text-gray-700">Recently Active Users</h2>
                <a href="{{ route('admin.users') }}" class="text-xs text-amber-600 hover:underline">View all</a>
            </div>
            <div class="space-y-3">
                @forelse($recentLogins as $u)
                <div class="flex items-center gap-3">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full
                                {{ $u->isAdmin() ? 'bg-purple-100 text-purple-700' : ($u->isVendor() ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700') }}
                                text-xs font-bold">
                        {{ strtoupper(substr($u->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="truncate text-sm font-medium text-gray-800">{{ $u->name }}</div>
                        <div class="text-xs text-gray-400 capitalize">{{ $u->role }}</div>
                    </div>
                    <div class="shrink-0 text-right">
                        <div class="text-xs text-gray-500">{{ $u->last_login_at->diffForHumans() }}</div>
                    </div>
                </div>
                @empty
                    <p class="text-sm text-gray-400">No logins recorded yet.</p>
                @endforelse
            </div>
        </div>

    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
<script>
    // Sales trend line chart
    new Chart(document.getElementById('salesChart'), {
        type: 'line',
        data: {
            labels: @json($trendLabels),
            datasets: [{
                label: 'Revenue (₱)',
                data: @json($trendRevenues),
                borderColor: '#d97706',
                backgroundColor: 'rgba(217,119,6,0.08)',
                borderWidth: 2,
                pointRadius: 3,
                pointBackgroundColor: '#d97706',
                fill: true,
                tension: 0.4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { callback: v => '₱' + v.toLocaleString() },
                    grid: { color: 'rgba(0,0,0,0.04)' }
                },
                x: { grid: { display: false } }
            }
        }
    });

    // Products by category doughnut chart
    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
            labels: @json($byCategory->pluck('category')),
            datasets: [{
                data: @json($byCategory->pluck('count')),
                backgroundColor: [
                    '#f59e0b','#3b82f6','#10b981','#8b5cf6','#ef4444',
                    '#f97316','#06b6d4','#84cc16','#ec4899','#6366f1',
                ],
                borderWidth: 2,
                borderColor: '#fff',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: { boxWidth: 12, font: { size: 11 } }
                }
            }
        }
    });
</script>
@endpush
</x-app-layout>
