<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'User',
            'email' => 'user@mail.com',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'name' => 'User 2',
            'email' => 'user2@mail.com',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'name' => 'User 3',
            'email' => 'user3@mail.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
