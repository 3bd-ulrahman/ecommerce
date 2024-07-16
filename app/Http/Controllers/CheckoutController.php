<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Mail\OrderReceived;
use App\Models\Order;
use App\Services\CartService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;
use Stripe\Exception\CardException;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CartService $cartService)
    {
        if (Auth::user()->shoppingItems()->count() === 0) {
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
        $cart = Auth::user()->load(['shoppingItems'])->shoppingItems;
        if ($cart->count() === 0) {
            return to_route('shop.index')->with([
                'error' => 'Your cart is empty',
            ]);
        }

        if ($request->coupon_code != Session::get('coupon.code')) {
            return to_route('checkout.index')->with([
                'error' => 'Coupon code is invalid',
            ]);
        }

        $discount = Session::get('coupon.discount') ?? 0;
        $subtotal = $cart->reduce(fn ($total, $item) => $total + $item['price'], 0);
        $tax = config('settings.tax');
        $total = round($subtotal + $subtotal * $tax - $discount, 2);

        $data = $cart->mapWithKeys(function ($item) {
            return [
                $item->id => [
                    'price' => $item->price,
                    'quantity' => $item->pivot->quantity,
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

            $pdf = LaravelMpdf::loadView('pdf.invoice', ['invoice' => $order]);

            Mail::to($user->email)->queue(
                (new OrderReceived(
                    $order,
                    base64_encode($pdf->output())
                ))->afterCommit()
            );

            Auth::user()->shoppingItems()->detach();

            return Inertia::render('Checkout/Thanks', [
                'order' => $order->load('products'),
                'discount' => $discount
            ]);
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
