<?php

namespace App\Services;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function cartValues(): collection
    {
        $cart = Auth::user()->load(['shoppingItems', 'wishlistItems']);

        $taxRate = config('settings.tax');

        $couponCode = session()->get('coupon')['code'] ?? null;

        $discount = session()->get('coupon')['discount'] ?? 0;

        return collect(compact(
            'cart',
            'taxRate',
            'couponCode',
            'discount',
        ));
    }
}
