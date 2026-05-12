<x-app-layout>
    <x-slot name="header">{{ $recipe->name }}</x-slot>

    <div class="space-y-6 max-w-3xl">

        @if(session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                {{ session('success') }}
            </div>
        @endif

        {{-- Meta --}}
        <div class="rounded-xl border border-stone-200 bg-white p-6 space-y-3">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <span class="inline-block rounded-full bg-amber-100 px-3 py-0.5 text-xs font-semibold text-amber-700">
                        {{ $recipe->category }}
                    </span>
                    <h1 class="mt-2 text-xl font-bold text-stone-800">{{ $recipe->name }}</h1>
                    @if($recipe->description)
                        <p class="mt-1 text-sm text-stone-600">{{ $recipe->description }}</p>
                    @endif
                    <p class="mt-2 text-sm text-stone-500">
                        Yields <strong class="text-stone-700">{{ $recipe->yield_quantity }} {{ $recipe->yield_unit }}</strong>
                    </p>
                </div>
                <div class="flex gap-2 shrink-0">
                    <a href="{{ route('baker.recipes.edit', $recipe) }}"
                       class="inline-flex items-center gap-1.5 rounded-lg border border-stone-200 px-3 py-1.5 text-sm font-medium text-stone-600 hover:bg-stone-50 transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/>
                        </svg>
                        Edit
                    </a>
                    <form method="POST" action="{{ route('baker.recipes.destroy', $recipe) }}"
                          onsubmit="return confirm('Delete this recipe?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 rounded-lg border border-red-200 px-3 py-1.5 text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                            </svg>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Ingredients --}}
        <div class="rounded-xl border border-stone-200 bg-white overflow-hidden">
            <div class="border-b border-stone-100 px-6 py-4">
                <h2 class="font-semibold text-stone-800">Ingredients</h2>
                <p class="text-xs text-stone-500 mt-0.5">
                    {{ $recipe->ingredients->where('is_critical', true)->count() }} required &middot;
                    {{ $recipe->ingredients->where('is_critical', false)->count() }} optional
                </p>
            </div>
            <table class="w-full text-sm">
                <thead class="bg-stone-50 text-xs uppercase tracking-wide text-stone-500">
                    <tr>
                        <th class="px-6 py-3 text-left">Ingredient</th>
                        <th class="px-6 py-3 text-right">Quantity</th>
                        <th class="px-6 py-3 text-left">Unit</th>
                        <th class="px-6 py-3 text-center">Required</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @foreach($recipe->ingredients->sortByDesc('is_critical') as $ing)
                        <tr class="hover:bg-stone-50">
                            <td class="px-6 py-3 font-medium text-stone-800">{{ $ing->ingredient_name }}</td>
                            <td class="px-6 py-3 text-right text-stone-600">{{ $ing->quantity }}</td>
                            <td class="px-6 py-3 text-stone-600">{{ $ing->unit }}</td>
                            <td class="px-6 py-3 text-center">
                                @if($ing->is_critical)
                                    <span class="inline-block rounded-full bg-amber-100 px-2 py-0.5 text-xs font-semibold text-amber-700">Yes</span>
                                @else
                                    <span class="inline-block rounded-full bg-stone-100 px-2 py-0.5 text-xs font-semibold text-stone-500">Optional</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <a href="{{ route('baker.recipes.index') }}" class="inline-flex items-center gap-1.5 text-sm text-stone-500 hover:text-stone-800 transition-colors">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
            </svg>
            Back to Recipes
        </a>
    </div>
</x-app-layout>
