<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // $faker = Faker::create();

        // for ($i = 1; $i <= 10; $i++) {

        //     User::create([
        //         'name' => $faker->name(),
        //         'email' => $faker->email(),
        //         'password' => bcrypt('2005'),
        //         'role' => 'employees',
        //         'phone' => $faker->numerify('03########')
        //     ]);
        // }

        // User::create([
        //     'name' => 'Tran Viet Giang',
        //     'email' => 'tranvietgiang@gmail.com',
        //     'password' => bcrypt('2005'),
        //     'role' => "admin",
        //     'phone' => '0336833827'
        // ]);

        // User::create([
        //     'name' => 'Ca pham',
        //     'email' => 'capham02@gmail.com',
        //     'password' => bcrypt('2005'),
        //     'role' => "employees",
        // ]);

        User::create([
            'name' => 'dHung',
            'email' => 'dHung@gmail.com',
            'password' => bcrypt('2005'),
            'role' => "user",
        ]);
    }
}
