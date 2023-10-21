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
        'subtotal',
        'tax',
        'total'
    ];


    // Relationships
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product', 'product_id', 'order_id');
    }
}
