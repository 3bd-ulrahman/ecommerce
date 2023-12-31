<?php

namespace Database\Seeders;

use App\Models\Category;
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
        // WOMENS
        for ($i=1; $i <= 12; $i++) {
            $category = Category::find(1);
            Product::create([
                'name' => 'Womens '.$i,
                'slug' => 'women-'.$i,
                'details' => 'women\'s hoodie',
                'description' =>'Lorem '. $i . ' ipsum dolor sit amet, consectetur adipisicing elit. Ipsum temporibus iusto ipsa, asperiores voluptas unde aspernatur praesentium in? Aliquam, dolore!',
                'image' => 'products/womens-'.$i.'.png',
                'product_code' => $category->category_code.'-00'.$i,
                'price' => rand(100, 1000),
                'quantity' => rand(1,10),
            ])->categories()->attach($category);
        }

        $product = Product::find(1);
        $product->categories()->attach(4);

        // MENS
        for ($i=1; $i <= 12; $i++) {
            $category = Category::find(2);
            Product::create([
                'name' => 'Mens '.$i,
                'slug' => 'mens-'.$i,
                'details' => 'men\'s hoodie',
                'description' =>'Lorem '. $i . ' ipsum dolor sit amet, consectetur adipisicing elit. Ipsum temporibus iusto ipsa, asperiores voluptas unde aspernatur praesentium in? Aliquam, dolore!',
                'image' => 'products/mens-'.$i.'.png',
                'product_code' => $category->category_code.'-00'.$i,
                'price' => rand(100, 1000),
                'quantity' => rand(1,10),
            ])->categories()->attach($category);
        }

        // Kids
        for ($i=1; $i <= 12; $i++) {
            $category = Category::find(3);
            Product::create([
                'name' => 'Kids '.$i,
                'slug' => 'kids-'.$i,
                'details' => 'kid\'s hoodie',
                'description' =>'Lorem '. $i . ' ipsum dolor sit amet, consectetur adipisicing elit. Ipsum temporibus iusto ipsa, asperiores voluptas unde aspernatur praesentium in? Aliquam, dolore!',
                'image' => 'products/kids-'.$i.'.png',
                'product_code' => $category->category_code.'-00'.$i,
                'price' => rand(100, 1000),
                'quantity' => rand(1,10),
            ])->categories()->attach($category);
        }

        // HOME GOODS
        for ($i=1; $i <= 12; $i++) {
            $category = Category::find(4);
            Product::create([
                'name' => 'Home Goods '.$i,
                'slug' => 'homegoods-'.$i,
                'details' => 'homegoods',
                'description' =>'Lorem '. $i . ' ipsum dolor sit amet, consectetur adipisicing elit. Ipsum temporibus iusto ipsa, asperiores voluptas unde aspernatur praesentium in? Aliquam, dolore!',
                'image' => 'products/homegoods-'.$i.'.png',
                'product_code' => $category->category_code.'-00'.$i,
                'price' => rand(100, 1000),
                'quantity' => rand(1,10),
            ])->categories()->attach($category);
        }
    }
}
