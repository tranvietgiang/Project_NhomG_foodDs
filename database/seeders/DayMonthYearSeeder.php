<?php

namespace Database\Seeders;

use App\Models\day;
use App\Models\month;
use App\Models\year;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DayMonthYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Thêm ngày 1 -> 31
        for ($i = 1; $i <= 31; $i++) {
            day::create(['day' => $i]);
        }

        // Thêm tháng 1 -> 12
        for ($i = 1; $i <= 12; $i++) {
            month::create(['month' => $i]);
        }

        // Thêm năm 2000 -> 2025
        for ($i = 2000; $i <= 2025; $i++) {
            year::create(['year' => $i]);
        }
    }
}
