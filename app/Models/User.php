<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'is_verified', 'last_login_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at'     => 'datetime',
            'password'          => 'hashed',
            'is_verified'       => 'boolean',
        ];
    }

    public function vendorProfile(): HasOne
    {
        return $this->hasOne(VendorProfile::class);
    }

    public function inventories(): HasMany
    {
        return $this->hasMany(BakerInventory::class);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function recommendations(): HasMany
    {
        return $this->hasMany(Recommendation::class);
    }

    public function sentMessages(): HasMany     { return $this->hasMany(Message::class, 'sender_id'); }
    public function receivedMessages(): HasMany { return $this->hasMany(Message::class, 'receiver_id'); }

    public function isAdmin(): bool   { return $this->role === 'admin'; }
    public function isVendor(): bool  { return $this->role === 'vendor'; }
    public function isBaker(): bool   { return $this->role === 'baker'; }
}