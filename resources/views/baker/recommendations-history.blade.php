<x-app-layout>
<x-slot name="header">Recommendation History</x-slot>

<div class="py-8 max-w-5xl mx-auto px-6 space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('baker.recommendations.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Back to Recommendations
        </a>
        <p class="text-sm text-gray-400">Generated {{ $generatedAt->format('M d, Y \a\t g:i A') }}</p>
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        @foreach($items as $r)
            @php
                $borderColor = $r->score >= 70 ? 'border-green-400' : ($r->score >= 40 ? 'border-amber-400' : 'border-gray-300');
                $badgeColor  = $r->score >= 70 ? 'bg-green-100 text-green-700' : ($r->score >= 40 ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-600');
            @endphp
            <div class="flex flex-col rounded-xl border-l-4 {{ $borderColor }} bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <h3 class="text-lg font-bold text-gray-900">{{ $r->product_name }}</h3>
                    <span class="shrink-0 rounded-full {{ $badgeColor }} px-3 py-0.5 text-sm font-bold">
                        {{ $r->score }}%
                    </span>
                </div>
                <p class="mt-2 text-sm text-gray-600 leading-relaxed">{{ $r->reason }}</p>
                @if(!empty($r->required_ingredients))
                    <div class="mt-3 flex flex-wrap gap-1.5">
                        @foreach($r->required_ingredients as $ing)
                            <span class="rounded-full bg-gray-100 px-2.5 py-0.5 text-xs text-gray-600">{{ $ing }}</span>
                        @endforeach
                    </div>
                @endif
                @if($r->feedback)
                    <div class="mt-3 border-t border-gray-100 pt-3">
                        <span class="text-xs text-gray-400">Your feedback: </span>
                        <span class="text-sm">{{ $r->feedback === 'up' ? '👍 Helpful' : '👎 Not helpful' }}</span>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

</div>
</x-app-layout>
