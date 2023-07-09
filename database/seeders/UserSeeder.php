<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                "name" => "Admin",
                "email" => "admin@gmail.com",
                "status" => 1,
                "role" => "admin",
                "password" => bcrypt("123456"),
                "created_at" =>now(),
                "updated_at" =>now()
            ]
        ];

        User::insert($data);
    }
}
