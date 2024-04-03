<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'reference_code',
        'address',
        'city',
        'state',
        'zip_code',
        'subtotal',
        'tax',
        'total'
    ];

    // Relationships
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id')
            ->withPivot('quantity');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }
}
