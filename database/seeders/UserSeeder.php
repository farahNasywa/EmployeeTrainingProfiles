<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create(['name' => 'admin', 'email' => 'adminbpma@gmail.com', 'role' => 'admin', 'password' => 'hulumigas4']);
        User::create(['name' => 'user', 'email' => 'userbpma@gmail.com', 'role' => 'user', 'password' => 'isogmigas4']);
    }
}
