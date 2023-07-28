<?php

use App\Http\Controllers\Cart\CartController;
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


// Shop
Route::get('shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('shop/{product:slug}', [ShopController::class, 'show'])->name('shop.show');


// Cart
Route::resource('cart', CartController::class);

Route::get('test', function () {
    return session()->all();
});

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
