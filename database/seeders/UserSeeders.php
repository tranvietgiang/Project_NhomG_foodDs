<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

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
        //         'role' => 'client',
        //         'phone' => $faker->numerify('03########')
        //     ]);
        // }

        // User::create([
        //     'name' => 'Tran Viet Giang',
        //     'email' => 'admin@gmail.com',
        //     'password' => bcrypt('2005'),
        //     'role' => "admin",
        //     'phone' => '99999999999'
        // ]);

        // User::create([
        //     'name' => 'Ca pham',
        //     'email' => 'capham02@gmail.com',
        //     'password' => bcrypt('2005'),
        //     'role' => "employees",
        // ]);

        // User::create([
        //     'name' => 'dHung',
        //     'email' => 'dHung@gmail.com',
        //     'password' => bcrypt('2005'),
        //     'role' => "user",
        // ]);

        $check = User::where('id', 28)->first();
        if ($check) {
            $check->password = Hash::make('200225Tvg@');
            $check->save();
        }

        // User::create([
        //     'name' => 'admin',
        //     'email' => 'admin@gmail.com',
        //     'password' => bcrypt('200225Tvg@'),
        //     'role' => "admin",
        // ]);
    }
}