<?php

namespace Database\Seeders;

use App\Models\Promotion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class promotionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        for ($i = 1; $i <= 20; $i++) {
            Promotion::create([
                'code' => 'HAPPY10' . $i,
                'name' => 'Giảm giá cuối tuần' . $i,
                'type' => 'percentage',
                'value' => random_int(10, 100), // Giảm 10%
                'usage_limit' => null, // Không giới hạn số lần sử dụng
                'used_count' => 0,
                'start_date' => '2024-05-20 00:00:00',
                'end_date' => '2024-06-30 23:59:59',
                'is_active' => true
            ]);
        }
    }
}