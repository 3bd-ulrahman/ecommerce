<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class MoveToCartController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($rowId)
    {
        $item = Cart::instance('saveForLater')->get($rowId);

        Cart::remove($rowId);

        Cart::instance('default')->add(
            $item->id,
            $item->name,
            $item->qty,
            $item->price,
            [
                'total_quantity' => $item->options->totalQuantity,
                'product_code' => $item->options->product_code,
                'image' => $item->options->image,
                'slug' => $item->options->slug,
                'details' => $item->options->details
            ]
        )->associate(Product::class);

        return to_route('cart.index');
    }
}
