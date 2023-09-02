<?php

namespace App\Services;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Collection;

class CartService
{
    public function cartValues(): collection
    {
        $cartItems = Cart::instance('default')->content();

        $taxRate = config('cart.tax');

        $cartSubTotal = Cart::subtotal();

        $couponCode = session()->get('coupon')['code'] ?? null;

        $discount = session()->get('coupon')['discount'] ?? 0;

        $cartTotal = Cart::total();

        $saveForLaterItems = Cart::instance('saveForLater')->content();

        return collect(compact(
            'cartItems',
            'taxRate',
            'cartSubTotal',
            'couponCode',
            'discount',
            'cartTotal',
            'saveForLaterItems',
        ));
    }
}
