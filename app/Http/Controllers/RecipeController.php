<?php
namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\RecipeIngredient;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::withCount('ingredients')
            ->orderBy('category')
            ->orderBy('name')
            ->paginate(20);

        return view('baker.recipes.index', compact('recipes'));
    }

    public function show(Recipe $recipe)
    {
        $recipe->load('ingredients');
        return view('baker.recipes.show', compact('recipe'));
    }

    public function create()
    {
        return view('baker.recipes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'category'      => ['required', 'string', 'max:100'],
            'description'   => ['nullable', 'string'],
            'yield_quantity'=> ['required', 'integer', 'min:1'],
            'yield_unit'    => ['required', 'string', 'max:50'],
            'ingredients'   => ['required', 'array', 'min:1'],
            'ingredients.*.ingredient_name' => ['required', 'string', 'max:255'],
            'ingredients.*.quantity'        => ['required', 'numeric', 'min:0'],
            'ingredients.*.unit'            => ['required', 'string', 'max:50'],
            'ingredients.*.is_critical'     => ['sometimes', 'boolean'],
        ]);

        $recipe = Recipe::create([
            'name'           => $data['name'],
            'category'       => $data['category'],
            'description'    => $data['description'] ?? null,
            'yield_quantity' => $data['yield_quantity'],
            'yield_unit'     => $data['yield_unit'],
        ]);

        foreach ($data['ingredients'] as $ing) {
            $recipe->ingredients()->create([
                'ingredient_name' => $ing['ingredient_name'],
                'quantity'        => $ing['quantity'],
                'unit'            => $ing['unit'],
                'is_critical'     => isset($ing['is_critical']) ? (bool) $ing['is_critical'] : true,
            ]);
        }

        return redirect()->route('baker.recipes.index')
            ->with('success', "Recipe \"{$recipe->name}\" created successfully.");
    }

    public function edit(Recipe $recipe)
    {
        $recipe->load('ingredients');
        return view('baker.recipes.edit', compact('recipe'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        $data = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'category'      => ['required', 'string', 'max:100'],
            'description'   => ['nullable', 'string'],
            'yield_quantity'=> ['required', 'integer', 'min:1'],
            'yield_unit'    => ['required', 'string', 'max:50'],
            'ingredients'   => ['required', 'array', 'min:1'],
            'ingredients.*.ingredient_name' => ['required', 'string', 'max:255'],
            'ingredients.*.quantity'        => ['required', 'numeric', 'min:0'],
            'ingredients.*.unit'            => ['required', 'string', 'max:50'],
            'ingredients.*.is_critical'     => ['sometimes', 'boolean'],
        ]);

        $recipe->update([
            'name'           => $data['name'],
            'category'       => $data['category'],
            'description'    => $data['description'] ?? null,
            'yield_quantity' => $data['yield_quantity'],
            'yield_unit'     => $data['yield_unit'],
        ]);

        $recipe->ingredients()->delete();

        foreach ($data['ingredients'] as $ing) {
            $recipe->ingredients()->create([
                'ingredient_name' => $ing['ingredient_name'],
                'quantity'        => $ing['quantity'],
                'unit'            => $ing['unit'],
                'is_critical'     => isset($ing['is_critical']) ? (bool) $ing['is_critical'] : true,
            ]);
        }

        return redirect()->route('baker.recipes.show', $recipe)
            ->with('success', "Recipe updated successfully.");
    }

    public function destroy(Recipe $recipe)
    {
        $name = $recipe->name;
        $recipe->delete();

        return redirect()->route('baker.recipes.index')
            ->with('success', "Recipe \"{$name}\" deleted.");
    }
}
