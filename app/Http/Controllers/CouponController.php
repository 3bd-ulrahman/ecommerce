<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
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
    public function store(Request $request)
    {
        $coupon = Coupon::query()->where('code', $request->coupon_code)->first();

        if (! $coupon) {
            return back()->withErrors([
                'message' => 'We couldn`t find your coupon. Please try again!'
            ]);
        }

        $cart = Auth::user()->load(['shoppingItems'])->shoppingItems;
        $subtotal = $cart->reduce(fn ($total, $item) => $total + $item['price'], 0);

        $discount = $coupon->discount($subtotal);

        session()->put('coupon', [
            'code' => $coupon->code,
            'discount' => $discount
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coupon $coupon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        Session::forget('coupon');

        return to_route('cart.index');
    }
}
