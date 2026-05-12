<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BakerInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'ingredient_name', 'quantity', 'unit', 'reorder_level',
    ];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}
