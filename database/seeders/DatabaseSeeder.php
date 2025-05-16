<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            // UserSeeders::class,
            CategorieSeeders::class,
            ProductsSeeder::class,
            DayMonthYearSeeder::class,

            // UserSeeders::class,
            // DiscountSeeder::class
        ]);
    }
}
