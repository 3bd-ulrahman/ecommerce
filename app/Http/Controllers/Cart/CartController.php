<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $shoppingItems = \App\Models\Cart::query()->user()
        //     ->shopping()
        //     ->with('product')
        //     ->get();

        // $wishlistItems = \App\Models\Cart::query()->user()
        //     ->wishlist()
        //     ->with('product')
        //     ->get();

        $shoppingItems = Auth::user()->load('shopping')->shopping;

        $wishlistItems = Auth::user()->load('wishlist')->wishlist;

        $taxRate = config('cart.tax');

        $couponCode = session()->get('coupon')['code'] ?? null;

        $discount = session()->get('coupon')['discount'] ?? 0;

        $cartTotal = Cart::total();

        return Inertia::render('Cart/Index', compact(
            'shoppingItems',
            'wishlistItems',
            'taxRate',
            'couponCode',
            'discount',
            'cartTotal'
        )
        );
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
        Auth::user()->shopping()->sync([
            $request->integer('id') => [
                'quantity' => $request->integer('quantity')
            ]
        ], false);

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
    public function update(Request $request, $id)
    {
        Auth::user()->shopping()->updateExistingPivot($id, [
            'quantity' => $request->integer('quantity'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Auth::user()->shopping()->detach($id);
    }
}
