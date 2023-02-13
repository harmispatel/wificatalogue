<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name'      =>      'Admin',
                'email'     =>      'admin@gmail.com',
                'user_type' =>      1,
                'password'  =>      Hash::make(123456),
            ],
        ];

        User::insert($users);
    }
}
