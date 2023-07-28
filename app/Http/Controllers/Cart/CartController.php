<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cartItems = Cart::content();

        $taxRate = config('cart.tax');

        $cartSubTotal = Cart::subtotal();

        $cartTotal = Cart::total();

        return Inertia::render('Cart/Index', compact(
            'cartItems',
            'taxRate',
            'cartSubTotal',
            'cartTotal'
        ));
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
        Cart::add(
            $request->id,
            $request->name,
            $request->quantity,
            $request->price,
            [
                'total_quantity' => $request->totalQuantity,
                'product_code' => $request->product_code,
                'image' => $request->image,
                'slug' => $request->slug,
                'details' => $request->details
            ]
        )->associate(Product::class);

        return to_route('cart.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
