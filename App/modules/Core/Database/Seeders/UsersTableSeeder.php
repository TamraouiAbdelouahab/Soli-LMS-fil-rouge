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
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ])->assignRole('responsable des apprenants');
    }
}
