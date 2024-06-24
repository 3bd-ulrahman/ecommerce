<?php

use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Cart\MoveToCartController;
use App\Http\Controllers\Cart\WishlistController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


/**
 * Constant
 */
define('PAGINATION', 10);



Route::get('/', [WelcomeController::class, 'index'])->name('welcome');


/**
 * SHOP
 */
Route::get('shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('shop/{product:slug}', [ShopController::class, 'show'])->name('shop.show');


/**
 * CART
 */
Route::resource('cart', CartController::class);

Route::post('cart/wishlist/{cart}', [WishlistController::class, 'store'])->name('cart.wishlist.store');
Route::patch('cart/wishlist/{cart}', [WishlistController::class, 'update'])->name('cart.wishlist.update');
Route::delete('cart/wishlist/{cart}', [WishlistController::class, 'destroy'])->name('cart.wishlist.destroy');

Route::post('cart/move-to-cart/{product}', MoveToCartController::class)->name('cart.move-to-cart.store');


/**
 * COUPONS
 */
Route::middleware('auth')->group(function () {
    Route::post('coupons' , [CouponController::class, 'store'])->name('coupons.store');
    Route::delete('coupons', [CouponController::class, 'destroy'])->name('coupons.destroy');
});


/**
 * CHECKOUT
 */
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
});


/**
 * ORDERS
 */
Route::middleware('auth')->group(function () {
    Route::get('orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order:reference_code}', [\App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
});


/**
 * INVOICES
 */
Route::middleware('auth')
    ->post('invoices/{order:reference_code}', \App\Http\Controllers\InvoiceController::class)
    ->name('invoices.show');

// Auth
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::get('readme', function () {
    return Illuminate\Mail\Markdown::parse(file_get_contents(base_path('README.md')));
});
