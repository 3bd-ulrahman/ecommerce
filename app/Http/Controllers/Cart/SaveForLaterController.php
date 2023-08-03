<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class SaveForLaterController extends Controller
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
    public function store($rowId)
    {
        $item = Cart::instance('default')->get($rowId);

        Cart::remove($rowId);

        Cart::instance('saveForLater')->add(
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
    public function destroy(string $rowId)
    {
        Cart::instance('saveForLater')->remove($rowId);

        return to_route('cart.index');
    }
}
