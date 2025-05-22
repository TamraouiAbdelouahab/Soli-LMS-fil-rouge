<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DureeSeance;

class DureeSeancesSeeder extends Seeder
{
    public function run()
    {
        // DureeSeance::truncate();

        DureeSeance::insert([
            ['duree_minutes' => 45, 'created_at' => now(), 'updated_at' => now()],
            ['duree_minutes' => 60, 'created_at' => now(), 'updated_at' => now()],
            ['duree_minutes' => 150, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
