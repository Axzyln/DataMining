<x-app-layout>
<x-slot name="header">AI Recommendation Activity</x-slot>

<div class="py-8 max-w-7xl mx-auto px-6 space-y-8">

    {{-- Stat cards --}}
    <div class="grid grid-cols-3 gap-4">
        <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-5">
            <div class="text-xs font-semibold uppercase tracking-wide text-gray-400">Total Generated</div>
            <div class="mt-1 text-3xl font-bold text-gray-900">{{ $totalGenerated }}</div>
            <div class="mt-1 text-xs text-gray-400">all-time recommendations</div>
        </div>
        <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-5">
            <div class="text-xs font-semibold uppercase tracking-wide text-gray-400">Positive Feedback</div>
            <div class="mt-1 text-3xl font-bold text-green-600">{{ $totalPositive }}</div>
            <div class="mt-1 text-xs text-gray-400">thumbs up from bakers</div>
        </div>
        <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-5">
            <div class="text-xs font-semibold uppercase tracking-wide text-gray-400">Negative Feedback</div>
            <div class="mt-1 text-3xl font-bold text-red-500">{{ $totalNegative }}</div>
            <div class="mt-1 text-xs text-gray-400">thumbs down from bakers</div>
        </div>
    </div>

    {{-- Baker breakdown --}}
    <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-6">
        <h2 class="mb-4 text-sm font-semibold text-gray-700">Baker AI Usage</h2>
        @if($bakerStats->isEmpty())
            <p class="text-sm text-gray-400">No recommendations have been generated yet.</p>
        @else
        <div class="overflow-hidden rounded-lg border border-gray-200">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-5 py-3 text-left">Baker</th>
                        <th class="px-5 py-3 text-center">Total Recs</th>
                        <th class="px-5 py-3 text-center">Thumbs Up</th>
                        <th class="px-5 py-3 text-center">Thumbs Down</th>
                        <th class="px-5 py-3 text-left">Last Generated</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($bakerStats as $baker)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-2.5">
                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-amber-100 text-xs font-bold text-amber-700">
                                    {{ strtoupper(substr($baker->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">{{ $baker->name }}</div>
                                    <div class="text-xs text-gray-400">{{ $baker->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-center font-semibold text-gray-800">{{ $baker->recommendations_count }}</td>
                        <td class="px-5 py-3 text-center text-green-600 font-semibold">{{ $baker->positive_feedback }}</td>
                        <td class="px-5 py-3 text-center text-red-500 font-semibold">{{ $baker->negative_feedback }}</td>
                        <td class="px-5 py-3 text-xs text-gray-400">
                            {{ $baker->last_generated ? \Carbon\Carbon::parse($baker->last_generated)->diffForHumans() : '—' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    {{-- Recent recommendations log --}}
    <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-6">
        <h2 class="mb-4 text-sm font-semibold text-gray-700">Recent AI Recommendations (Last 20)</h2>
        @if($recentRecs->isEmpty())
            <p class="text-sm text-gray-400">No recommendations recorded yet.</p>
        @else
        <div class="overflow-hidden rounded-lg border border-gray-200">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-5 py-3 text-left">Baker</th>
                        <th class="px-5 py-3 text-left">Product</th>
                        <th class="px-5 py-3 text-center">Score</th>
                        <th class="px-5 py-3 text-center">Feedback</th>
                        <th class="px-5 py-3 text-left">Generated</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($recentRecs as $rec)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 text-gray-700">{{ $rec->user?->name ?? '—' }}</td>
                        <td class="px-5 py-3 font-medium text-gray-900">{{ $rec->product_name }}</td>
                        <td class="px-5 py-3 text-center">
                            <span class="inline-block rounded-full px-2 py-0.5 text-xs font-semibold
                                {{ $rec->score >= 70 ? 'bg-green-100 text-green-700' : ($rec->score >= 40 ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-500') }}">
                                {{ $rec->score }}%
                            </span>
                        </td>
                        <td class="px-5 py-3 text-center">
                            @if($rec->feedback === 'up')
                                <span class="text-green-500">👍</span>
                            @elseif($rec->feedback === 'down')
                                <span class="text-red-400">👎</span>
                            @else
                                <span class="text-gray-300 text-xs">—</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-xs text-gray-400">{{ $rec->created_at->diffForHumans() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</div>
</x-app-layout>
