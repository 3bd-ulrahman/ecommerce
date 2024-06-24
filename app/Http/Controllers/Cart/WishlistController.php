<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(\App\Models\Cart $cart)
    {
        $cart->update(['instance' => 'wishlist']);

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
    public function update(Request $request, \App\Models\Cart $cart)
    {
        return $cart;
        Cart::instance('saveForLater')->update($id, $request->integer('quantity'));

        return to_route('cart.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $rowId)
    {
        Cart::instance('saveForLater')->remove($rowId);

        return to_route('cart.index');
    }
}
