<x-app-layout>
    <x-slot name="header">Add Recipe</x-slot>

    <div class="max-w-3xl" x-data="recipeForm()">
        <form method="POST" action="{{ route('baker.recipes.store') }}" class="space-y-6">
            @csrf

            {{-- Basic info --}}
            <div class="rounded-xl border border-stone-200 bg-white p-6 space-y-4">
                <h2 class="font-semibold text-stone-800">Recipe Info</h2>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1">Recipe Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500 @error('name') border-red-400 @enderror">
                        @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1">Category <span class="text-red-500">*</span></label>
                        <input type="text" name="category" value="{{ old('category') }}" required
                               list="category-list"
                               class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500 @error('category') border-red-400 @enderror">
                        <datalist id="category-list">
                            <option value="Yeast Bread">
                            <option value="Cake & Pastry">
                            <option value="Cookie">
                            <option value="Kakanin">
                        </datalist>
                        @error('category')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1">Description</label>
                    <textarea name="description" rows="2"
                              class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500">{{ old('description') }}</textarea>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1">Yield Quantity <span class="text-red-500">*</span></label>
                        <input type="number" name="yield_quantity" value="{{ old('yield_quantity', 1) }}" min="1" required
                               class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1">Yield Unit <span class="text-red-500">*</span></label>
                        <input type="text" name="yield_unit" value="{{ old('yield_unit', 'pieces') }}" required
                               class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500">
                    </div>
                </div>
            </div>

            {{-- Ingredients --}}
            <div class="rounded-xl border border-stone-200 bg-white p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="font-semibold text-stone-800">Ingredients</h2>
                    <button type="button" @click="addRow()"
                            class="inline-flex items-center gap-1 rounded-lg border border-stone-300 px-3 py-1.5 text-xs font-medium text-stone-600 hover:bg-stone-50 transition-colors">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Add Row
                    </button>
                </div>

                @error('ingredients')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="text-xs uppercase tracking-wide text-stone-500">
                            <tr>
                                <th class="pb-2 text-left pr-3">Ingredient Name</th>
                                <th class="pb-2 text-left pr-3 w-24">Qty</th>
                                <th class="pb-2 text-left pr-3 w-28">Unit</th>
                                <th class="pb-2 text-center w-20">Required</th>
                                <th class="pb-2 w-8"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            <template x-for="(row, idx) in rows" :key="idx">
                                <tr>
                                    <td class="py-2 pr-3">
                                        <input type="text" :name="`ingredients[${idx}][ingredient_name]`"
                                               x-model="row.ingredient_name" required
                                               class="w-full rounded-md border border-stone-300 px-2 py-1.5 text-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500">
                                    </td>
                                    <td class="py-2 pr-3">
                                        <input type="number" :name="`ingredients[${idx}][quantity]`"
                                               x-model="row.quantity" min="0" step="0.01" required
                                               class="w-full rounded-md border border-stone-300 px-2 py-1.5 text-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500">
                                    </td>
                                    <td class="py-2 pr-3">
                                        <input type="text" :name="`ingredients[${idx}][unit]`"
                                               x-model="row.unit" required list="unit-list"
                                               class="w-full rounded-md border border-stone-300 px-2 py-1.5 text-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500">
                                    </td>
                                    <td class="py-2 pr-3 text-center">
                                        <input type="hidden" :name="`ingredients[${idx}][is_critical]`" value="0">
                                        <input type="checkbox" :name="`ingredients[${idx}][is_critical]`"
                                               x-model="row.is_critical" value="1"
                                               class="h-4 w-4 rounded border-stone-300 text-amber-600 focus:ring-amber-500">
                                    </td>
                                    <td class="py-2">
                                        <button type="button" @click="removeRow(idx)"
                                                x-show="rows.length > 1"
                                                class="text-stone-400 hover:text-red-500 transition-colors">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
                <datalist id="unit-list">
                    <option value="grams"><option value="kg"><option value="ml"><option value="liters">
                    <option value="cups"><option value="tbsp"><option value="tsp"><option value="pieces">
                    <option value="pcs"><option value="pack"><option value="cans">
                </datalist>
                <p class="text-xs text-stone-500">"Required" means the product cannot be made without this ingredient.</p>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-amber-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-amber-700 transition-colors">
                    Save Recipe
                </button>
                <a href="{{ route('baker.recipes.index') }}"
                   class="inline-flex items-center rounded-lg border border-stone-300 px-5 py-2.5 text-sm font-medium text-stone-600 hover:bg-stone-50 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <script>
        function recipeForm() {
            return {
                rows: [{ ingredient_name: '', quantity: '', unit: '', is_critical: true }],
                addRow() {
                    this.rows.push({ ingredient_name: '', quantity: '', unit: '', is_critical: true });
                },
                removeRow(idx) {
                    if (this.rows.length > 1) this.rows.splice(idx, 1);
                }
            };
        }
    </script>
</x-app-layout>
