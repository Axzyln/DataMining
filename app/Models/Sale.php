<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'product_name', 'quantity_sold',
        'unit_price', 'total', 'sale_date',
    ];

    protected $casts = ['sale_date' => 'date'];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}