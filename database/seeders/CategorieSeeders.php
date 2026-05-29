<?php

namespace Database\Seeders;

use App\Models\Categorie;
use Illuminate\Database\Seeder;

class CategorieSeeders extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Do an nhanh',
            'Tra sua',
            'Ca phe',
            'Tra trai cay',
            'Dac san Viet',
            'Trai cay tuoi',
        ];

        foreach ($categories as $name) {
            Categorie::updateOrCreate(
                ['categories_name' => $name],
                ['categories_name' => $name]
            );
        }
    }
}
