<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Laravel\Scout\Searchable;
use NumberFormatter;

class Product extends Model
{
    use HasFactory, Searchable;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'slug',
        'details',
        'description',
        'product_code',
        'image',
        'price',
        'quantity',
    ];

    protected $casts = [
        'price' => 'double'
    ];

    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
        ];
    }

    // Relationships
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }


    // Accessors & Mutators
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => '/storage/images/' . $value,
        );
    }
}
