<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Core\App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // User::truncate();

        User::create([
            'name' => 'Admin elAmrani',
            'email' => 'ahmed.elamrani@gmail.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Fatima Zahra Boulahdour',
            'email' => 'fatimazahra.boulahdour@gmail.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Youssef Benjelloun',
            'email' => 'youssef.benjelloun@gmail.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Souad Amrani',
            'email' => 'souad.amrani@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
