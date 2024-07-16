<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class OrderObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        $products = $order->products;

        $result = $products->map(function ($product) {
            $item = $product->toArray();
            $item['quantity'] -= $item['pivot']['quantity'];
            unset($item['created_at']);
            unset($item['updated_at']);
            unset($item['pivot']);

            return $item;
        })->toArray();

        Product::query()->upsert($result, ['id'], ['quantity']);
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
