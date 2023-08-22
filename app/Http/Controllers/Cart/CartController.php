<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cartItems = Cart::instance('default')->content();

        $taxRate = config('cart.tax');

        $cartSubTotal = Cart::subtotal();

        $couponCode = session()->get('coupon')['code'] ?? null;

        $discount = session()->get('coupon')['discount'] ?? 0;

        $cartTotal = Cart::total();

        $saveForLaterItems = Cart::instance('saveForLater')->content();

        return Inertia::render('Cart/Index', compact(
            'cartItems',
            'taxRate',
            'cartSubTotal',
            'couponCode',
            'discount',
            'cartTotal',
            'saveForLaterItems'
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
            $request->integer('quantity'),
            $request->integer('price'),
            [
                'total_quantity' => $request->integer('totalQuantity'),
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
        Cart::instance('default')->update($id, $request->integer('quantity'));

        return to_route('cart.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $rowId)
    {
        Cart::instance('default')->remove($rowId);

        return to_route('cart.index');
    }
}
