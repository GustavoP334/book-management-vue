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
            'email' => 'admin@example.com',
            'is_admin' => 1,
            'password' => bcrypt('password123')
        ]);
        
        User::create([
            'name' => 'casual',
            'email' => 'casual@example.com',
            'is_admin' => 0,
            'password' => bcrypt('password123')
        ]);
    }
}

