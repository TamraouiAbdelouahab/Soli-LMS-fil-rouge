<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Core\App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // User::truncate();

        User::create([
            'email' => 'ahmed.elamrani@gmail.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'email' => 'fatimazahra.boulahdour@gmail.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'email' => 'youssef.benjelloun@gmail.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'email' => 'souad.amrani@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
