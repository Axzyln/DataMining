<x-app-layout>
<x-slot name="header">AI Recommendations</x-slot>

<div class="py-8 max-w-5xl mx-auto px-6 space-y-6">

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="flex items-center gap-3 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
            <svg class="h-4 w-4 shrink-0 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="flex items-start gap-3 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-800">
            <svg class="mt-0.5 h-4 w-4 shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- Generate panel --}}
    <div x-data="{ loading: false }" class="rounded-xl bg-gradient-to-br from-amber-50 to-orange-50 border border-amber-200 p-6">
        <div class="flex items-start gap-4">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-amber-600 text-white text-lg">✦</div>
            <div class="flex-1">
                <h2 class="font-semibold text-gray-900">Groq AI Recommendations</h2>
                <p class="mt-1 text-sm text-gray-600">
                    Analyzes your inventory and sales to suggest products to bake next.
                    Powered by <span class="font-medium text-amber-700">{{ env('GROQ_MODEL', 'llama-3.3-70b-versatile') }}</span>.
                </p>
                <form method="POST" action="{{ route('baker.recommendations.generate') }}"
                      class="mt-4" @submit="loading = true">
                    @csrf
                    <button type="submit" :disabled="loading"
                            class="inline-flex items-center gap-2 rounded-lg bg-amber-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-amber-700 disabled:opacity-60 transition-colors">
                        <svg x-show="!loading" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                        </svg>
                        <svg x-show="loading" class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                        </svg>
                        <span x-text="loading ? 'Generating…' : 'Generate Recommendations'"></span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Current batch --}}
    @if($recommendations->isNotEmpty())
        <div class="flex items-center justify-between">
            <p class="text-sm text-gray-500">
                {{ $recommendations->count() }} recommendations — generated {{ $recommendations->first()->created_at->diffForHumans() }}
            </p>
        </div>
    @endif

    <div class="grid md:grid-cols-2 gap-4">
        @forelse($recommendations as $r)
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

                {{-- Feedback --}}
                <div class="mt-4 flex items-center gap-2 border-t border-gray-100 pt-3">
                    <span class="text-xs text-gray-400 mr-1">Was this helpful?</span>
                    <form method="POST" action="{{ route('baker.recommendations.feedback', $r) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="feedback" value="up">
                        <button type="submit"
                                class="inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-medium transition-colors
                                    {{ $r->feedback === 'up' ? 'bg-green-100 text-green-700 ring-1 ring-green-400' : 'bg-gray-100 text-gray-500 hover:bg-green-50 hover:text-green-600' }}">
                            👍 Yes
                        </button>
                    </form>
                    <form method="POST" action="{{ route('baker.recommendations.feedback', $r) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="feedback" value="down">
                        <button type="submit"
                                class="inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-medium transition-colors
                                    {{ $r->feedback === 'down' ? 'bg-red-100 text-red-600 ring-1 ring-red-300' : 'bg-gray-100 text-gray-500 hover:bg-red-50 hover:text-red-500' }}">
                            👎 No
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-2 rounded-xl border border-dashed border-gray-300 bg-white p-14 text-center">
                <div class="mx-auto mb-3 text-4xl">✦</div>
                <p class="font-medium text-gray-500">No recommendations yet</p>
                <p class="mt-1 text-sm text-gray-400">Click <b>Generate Recommendations</b> above to get started.</p>
            </div>
        @endforelse
    </div>

    {{-- History --}}
    @if($history->isNotEmpty())
    <div class="rounded-xl bg-white border border-gray-100 shadow-sm p-6">
        <h2 class="mb-4 text-sm font-semibold text-gray-700">Previous Recommendation Batches</h2>
        <div class="space-y-2">
            @foreach($history as $batch)
            <a href="{{ route('baker.recommendations.batch', $batch->batch_id) }}"
               class="flex items-center justify-between rounded-lg border border-gray-100 px-4 py-3 hover:border-amber-200 hover:bg-amber-50 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-amber-100 text-amber-600 text-xs font-bold">
                        {{ $batch->count }}
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-800">{{ $batch->count }} recommendations</div>
                        <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($batch->generated_at)->format('M d, Y \a\t g:i A') }}</div>
                    </div>
                </div>
                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                </svg>
            </a>
            @endforeach
        </div>
    </div>
    @endif

</div>
</x-app-layout>
