<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Services\CartService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Stripe\Exception\CardException;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CartService $cartService)
    {
        if (Cart::instance('default')->count() === 0) {
            return to_route('shop.index')->with([
                'error' => 'Your cart is empty',
            ]);
        }

        return Inertia::render('Checkout/Index', $cartService->cartValues()->toArray());
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
        if (Cart::instance('default')->count() === 0) {
            return to_route('shop.index')->with([
                'erorr' => 'Your cart is empty',
            ]);
        }

        $discount = Session::get('coupon.discount') ?? 0;
        $subtotal = (int) Cart::instance('default')->subtotal();
        $tax = config('cart.tax');
        $total = (int) Cart::instance('default')->total() - $discount;

        $data = Cart::content()->mapWithKeys(function ($item) {
            return [
                $item->id => [
                    'price' => $item->price,
                    'quantity' => $item->qty,
                ]
            ];
        })->toArray();

        DB::beginTransaction();
        $user = auth()->user();
        $order = $user->orders()->create([
            'reference_code' => Str::uuid(),
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'sub_total' => $subtotal,
            'tax' => $tax,
            'total' => $total
        ]);

        $order->products()->sync($data);

        try {
            $user->charge($total * 100, $request->paymentMethod['id']);

            DB::commit();

            Session::forget(['cart', 'coupon']);

            return Inertia::render('Checkout/Thanks', compact('order', 'discount'));
        } catch (CardException $e) {
            DB::rollback();
            return to_route('checkout.index')->withErrors([
                'message' => $e->getMessage()
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
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
