<x-app-layout>
    <x-slot name="header">Recipe Database</x-slot>

    <div class="space-y-6">

        {{-- Header row --}}
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-stone-500">{{ $recipes->total() }} recipes in the database</p>
            </div>
            <a href="{{ route('baker.recipes.create') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-amber-600 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-700 transition-colors">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Add Recipe
            </a>
        </div>

        @if(session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                {{ session('success') }}
            </div>
        @endif

        {{-- Group by category --}}
        @php
            $grouped = $recipes->getCollection()->groupBy('category');
            $categories = ['Yeast Bread', 'Cake & Pastry', 'Cookie', 'Kakanin'];
            $allCats = $grouped->keys()->toArray();
            $orderedCats = array_merge(
                array_intersect($categories, $allCats),
                array_diff($allCats, $categories)
            );
        @endphp

        @forelse($orderedCats as $cat)
            <div>
                <h2 class="mb-3 text-xs font-semibold uppercase tracking-wider text-stone-500">{{ $cat }}</h2>
                <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($grouped[$cat] as $recipe)
                        <a href="{{ route('baker.recipes.show', $recipe) }}"
                           class="flex items-start justify-between rounded-xl border border-stone-200 bg-white p-4 hover:border-amber-400 hover:shadow-sm transition-all">
                            <div class="min-w-0">
                                <p class="font-semibold text-stone-800 truncate">{{ $recipe->name }}</p>
                                <p class="text-xs text-stone-500 mt-0.5">
                                    Yields {{ $recipe->yield_quantity }} {{ $recipe->yield_unit }}
                                    &middot; {{ $recipe->ingredients_count }} ingredients
                                </p>
                            </div>
                            <svg class="ml-2 h-4 w-4 shrink-0 text-stone-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                            </svg>
                        </a>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="rounded-xl border border-dashed border-stone-300 py-16 text-center">
                <p class="text-stone-500">No recipes yet. Add one to get started.</p>
                <a href="{{ route('baker.recipes.create') }}" class="mt-3 inline-block text-sm font-medium text-amber-600 hover:underline">Add Recipe</a>
            </div>
        @endforelse

        {{ $recipes->links() }}
    </div>
</x-app-layout>
