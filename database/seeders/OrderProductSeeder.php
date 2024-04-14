<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orderProduct = [];

        for ($i=0; $i < 10; $i++) {
            array_push($orderProduct, [
                'order_id' => fake()->numberBetween(1, 50),
                'product_id' => fake()->numberBetween(1, 50),
                'price' => 20,
                'quantity' => fake()->numberBetween(1, 5)
            ]);
        }

        DB::table('order_product')->insert($orderProduct);
    }
}
