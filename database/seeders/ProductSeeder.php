<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [];
        // WOMENS
        for ($i=1; $i <= 12; $i++) {
            array_push($products, [
                'name' => 'Womens '.$i,
                'slug' => 'women-'.$i,
                'details' => 'women\'s hoodie',
                'description' =>'Lorem '. $i . ' ipsum dolor sit amet, consectetur adipisicing elit. Ipsum temporibus iusto ipsa, asperiores voluptas unde aspernatur praesentium in? Aliquam, dolore!',
                'product_code' => '-00'.$i,
                'price' => rand(999, 9999),
                'quantity' => rand(1,10),
            ]);
        }

        // MENS
        for ($i=1; $i <= 12; $i++) {
            array_push($products, [
                'name' => 'Mens '.$i,
                'slug' => 'men-'.$i,
                'details' => 'men\'s hoodie',
                'description' =>'Lorem '. $i . ' ipsum dolor sit amet, consectetur adipisicing elit. Ipsum temporibus iusto ipsa, asperiores voluptas unde aspernatur praesentium in? Aliquam, dolore!',
                'product_code' => '-00'.$i,
                'price' => rand(999, 9999),
                'quantity' => rand(1,10),
            ]);
        }

        // KIDS
        for ($i=1; $i <= 12; $i++) {
            array_push($products, [
                'name' => 'Kids '.$i,
                'slug' => 'Kid-'.$i,
                'details' => 'Kid\'s hoodie',
                'description' =>'Lorem '. $i . ' ipsum dolor sit amet, consectetur adipisicing elit. Ipsum temporibus iusto ipsa, asperiores voluptas unde aspernatur praesentium in? Aliquam, dolore!',
                'product_code' => '-00'.$i,
                'price' => rand(999, 9999),
                'quantity' => rand(1,10),
            ]);
        }

        // HOME GOODS
        for ($i=1; $i <= 12; $i++) {
            array_push($products, [
                'name' => 'Home Goods '.$i,
                'slug' => 'homegoods-'.$i,
                'details' => 'homegoods',
                'description' =>'Lorem '. $i . ' ipsum dolor sit amet, consectetur adipisicing elit. Ipsum temporibus iusto ipsa, asperiores voluptas unde aspernatur praesentium in? Aliquam, dolore!',
                'product_code' => '-00'.$i,
                'price' => rand(999, 9999),
                'quantity' => rand(1,10),
            ]);
        }

        Product::insert($products);
    }
}
