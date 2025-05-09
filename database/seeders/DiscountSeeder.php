<?php

namespace Database\Seeders;

use App\Models\discount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        discount::create([
            'discount_name' => 'ban_cua_giang',
            'discount_price' => 2000000,
        ]);
    }
}
