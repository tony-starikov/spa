<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('admin'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'User',
            'email' => 'user@mail.com',
            'password' => bcrypt('user'),
            'role' => 'user',
        ]);
    }
}
