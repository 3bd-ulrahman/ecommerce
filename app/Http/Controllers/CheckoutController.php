<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\User;
use App\Services\CartService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Stripe\Exception\CardException;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CartService $cartService)
    {
        return Inertia::render('Checkout/index', $cartService->cartValues()->toArray());
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
    public function store(CheckoutRequest $request)
    {
        $coupon = Session::get('coupon.discount') ?? 0;
        $subtotal = (int) Cart::instance('default')->subtotal();
        $tax = config('cart.tax');
        $total = (int) Cart::instance('default')->total() - $coupon;

        $data = Cart::content()->mapWithKeys(function ($item) {
            return [$item->id => [
                'price' => $item->price,
                'quantity' => $item->qty,
            ]];
        })->toArray();

        $user = auth()->user();
        $order = $user->orders()->create([
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total
        ]);

        $order->products()->sync($data);

        try {
            $user->charge($total * 100, $request->paymentMethod['id']);

            return to_route('cart.index');
        } catch (CardException $e) {
            return to_route('checkout.index')->withErrors([
                'message' => $e->getMessage()
            ]);
        } catch (\Throwable $th) {
            return to_route('checkout.index')->withErrors([
                'message' => $th->getMessage()
            ]);
        }
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
