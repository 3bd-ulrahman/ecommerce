<?php

use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Cart\MoveToCartController;
use App\Http\Controllers\Cart\SaveForLaterController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');


/**
 * SHOP
 */
Route::get('shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('shop/{product:slug}', [ShopController::class, 'show'])->name('shop.show');


/**
 * CART
 */
Route::resource('cart', CartController::class)->parameter('cart', 'product');

Route::post('cart/save-for-later/{product}', [SaveForLaterController::class, 'store'])->name('cart.save-for-later.store');
Route::patch('cart/save-for-later/{product}', [SaveForLaterController::class, 'update'])->name('cart.save-for-later.update');
Route::delete('cart/save-for-later/{product}', [SaveForLaterController::class, 'destroy'])->name('cart.save-for-later.destroy');

Route::post('cart/move-to-cart/{product}', MoveToCartController::class)->name('cart.move-to-cart.store');


/**
 * COUPONS
 */
Route::post('coupons' , [CouponController::class, 'store'])->name('coupons.store');
Route::delete('coupons', [CouponController::class, 'destroy'])->name('coupons.destroy');


/**
 * CHECKOUT
 */
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');


// Auth
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
