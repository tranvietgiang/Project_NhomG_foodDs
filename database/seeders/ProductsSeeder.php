<?php

namespace Database\Seeders;

use App\Models\Product;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 1; $i <= 5; $i++) {
            Product::create([
                'product_name' => $faker->sentence(3),
                'product_image' => 'default.jpg',
                'categories_id' => $faker->numberBetween(1, 5), // Changed from category_id to categories_id
                'product_price' => $faker->numberBetween(50000, 200000),
                'quantity_store' => $faker->numberBetween(10, 15),
            ]);
        }
    }
}