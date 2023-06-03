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
        $arr = [
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'address' => 'home',
            'phone' => '0000',
            'password' => bcrypt('123456'),
            'role_as' => 1,
        ];

        User::create($arr);
    }
}
