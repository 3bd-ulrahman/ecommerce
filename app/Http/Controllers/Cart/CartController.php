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
        $cart = Auth::user()->load(['shoppingItems', 'wishlistItems']);

        $taxRate = config('settings.tax');

        $couponCode = session()->get('coupon')['code'] ?? null;

        $discount = session()->get('coupon')['discount'] ?? 0;

        return Inertia::render('Cart/Index', compact(
            'cart',
            'taxRate',
            'couponCode',
            'discount'
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
        Auth::user()->cartItems()->sync([
            $request->integer('id') => [
                'quantity' => $request->integer('quantity'),
                'instance' => 'shopping'
            ]
        ], false);
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
        Auth::user()->cartItems()->updateExistingPivot($id, [
            'quantity' => $request->integer('quantity'),
            'instance' => 'shopping'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Auth::user()->shoppingItems()->detach($id);
    }
}
