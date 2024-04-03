<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run($user_id): void
    {
        $orders = [];

        for ($i=0; $i < 10; $i++) {
            array_push($orders, [
                'user_id' => $user_id,
                'reference_code' => Str::uuid(),
                'subtotal' => fake()->randomNumber(5),
                'tax' => 20,
                'total' => fake()->randomNumber(5)
            ]);
        }

        Order::query()->insert($orders);
    }
}
