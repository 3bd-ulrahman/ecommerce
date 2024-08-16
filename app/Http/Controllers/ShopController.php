<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        $products = Product::query()->when(request()->category, function ($query) {
            $query->whereHas('categories', function($query) {
                $query->where('slug', request()->category);
            })->when(request()->sort === 'high_low', function ($query) {
                $query->orderBy('price', 'desc');
            }, fn($query) => $query->orderBy('price', 'asc'));
        })->inRandomOrder()->get();


        return Inertia::render('Shop/Index', compact('categories', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $similarProducts = Product::whereHas('categories', function ($query) use ($product) {
            $query->whereIn('categories.id', $product->categories->pluck('id'));
        })->where('products.id', '!=', $product->id)->take(4)->inRandomOrder()->get();

        return Inertia::render('Shop/Show', [
            'product' => $product,
            'similarProducts' => $similarProducts
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
