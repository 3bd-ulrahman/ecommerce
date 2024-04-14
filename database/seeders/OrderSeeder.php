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
    public function run(): void
    {
        $orders = [];

        for ($i=0; $i < 50; $i++) {
            array_push($orders, [
                'user_id' => fake()->numberBetween(1, 10),
                'reference_code' => Str::uuid(),
                'address' => fake()->address(),
                'city' => fake()->city(),
                'state' => fake()->state(),
                'zip_code' => fake()->postcode(),
                'subtotal' => fake()->randomNumber(5),
                'tax' => 20,
                'total' => fake()->randomNumber(5)
            ]);
        }

        Order::query()->insert($orders);
    }
}
