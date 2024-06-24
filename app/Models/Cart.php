<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';

    protected $fillable = [
        'user_id',
        'product_id',
        'instance',
        'quantity'
    ];

    // Relationships
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    // Methods
    public function scopeUser(Builder $query): void
    {
        $query->where('user_id', auth()->user()->id);
    }

    public function scopeShopping(Builder $query): void
    {
        $query->where('instance', 'shopping');
    }

    public function scopeWishlist(Builder $query): void
    {
        $query->where('instance', 'wishlist');
    }

    public function shopping()
    {
        return $this->belongsToMany(Product::class, 'carts', 'product_id')
            ->wherePivot('instance', 'shopping');
    }

    public function wishlist()
    {
        return $this->belongsToMany(Product::class, 'carts')
            ->wherePivot('instance', 'wishlist');
    }
}
