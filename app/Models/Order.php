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
        'sub_total',
        'tax',
        'total'
    ];

    protected $casts = [
      'created_at' => 'datetime:j/n/Y',
    ];

    // Relationships
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id')
            ->withPivot(['quantity', 'price']);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }
}
