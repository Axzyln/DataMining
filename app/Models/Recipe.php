<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recipe extends Model
{
    protected $fillable = ['name', 'category', 'description', 'yield_quantity', 'yield_unit'];

    public function ingredients(): HasMany
    {
        return $this->hasMany(RecipeIngredient::class);
    }

    public function criticalIngredients(): HasMany
    {
        return $this->hasMany(RecipeIngredient::class)->where('is_critical', true);
    }
}
