<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Coupon::create([
            'code' => 'ABC123',
            'value' => 100,
            'type' => 'fixed'
        ]);

        Coupon::create([
            'code' => 'DEF456',
            'value' => 10,
            'type' => 'percent'
        ]);
    }
}
