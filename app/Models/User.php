<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use Billable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'profile_photo_url'
    ];

    // Relationships
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    public function cartItems(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'carts')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function shoppingItems(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'carts')
            ->wherePivot('instance', 'shopping')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function wishlistItems(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'carts')
            ->wherePivot('instance', 'wishlist')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
