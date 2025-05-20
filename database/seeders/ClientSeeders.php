<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ClientSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */

    // Lấy danh sách tất cả các user_id có trong bảng users
    public function run(): void
    {
        //
        $faker = Faker::create();
        // Lấy tất cả các user_id, rồi loại bỏ 25, 26, 27
        // whereNotIn() yêu cầu tham số thứ 2 phải là một mảng (array), nhưng bạn đang truyền vào một chuỗi
        $userIds = User::whereNotIn('id', [25, 26, 27, 28])
            ->whereNotIn('role', ['employees'])
            ->pluck('id')->toArray();

        foreach ($userIds as $item) {
            $hasClient = Client::where('user_id', $item)->exists();
            if (!$hasClient) {
                Client::create([
                    'user_id' => $item,
                    'client_name' => $faker->name(),
                    'client_phone' => $faker->numerify('03########'),
                    'client_address' => $faker->address(),
                    'client_gender' => $faker->randomElement(['Nam', 'Nữ']),
                    'dat_of_birth' => $faker->dateTimeBetween('-60 years', '-18 years')->format('Y/m/d'),
                    'login_count' => $faker->numberBetween(1, 30)
                ]);
            }
        }
    }
}