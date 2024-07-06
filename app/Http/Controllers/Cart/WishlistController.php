<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        Auth::user()->cartItems()->updateExistingPivot($id, [
            'quantity' => $request->integer('quantity'),
            'instance' => 'wishlist'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Auth::user()->wishlistItems()->detach($id);
    }
}
