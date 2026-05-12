<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecipeIngredient extends Model
{
    protected $fillable = ['recipe_id', 'ingredient_name', 'quantity', 'unit', 'is_critical'];

    protected $casts = ['is_critical' => 'boolean'];

    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }
}
