<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create();
        for ($i = 1; $i <= 5; $i++) {
            Product::create([
                'product_name' => $faker->sentence(3),
                'product_image' => $faker->imageUrl(640, 480, 'movies', true, 'Faker'),
                'categories_id' => $faker->numberBetween(1, 5),
                'product_price' => $faker->randomFloat(2, 100, 1000), // Giá ngẫu nhiên từ 100 đến 1000 với 2 chữ số thập phân
                'quantity_store' => $faker->numberBetween(10, 15),
            ]);
        }
    }
}