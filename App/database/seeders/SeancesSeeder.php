<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seance;

class SeancesSeeder extends Seeder
{
    public function run()
    {
        // Seance::truncate();

        // DureeSeance IDs 1,2,3
        foreach ([1,2,3] as $dureeId) {
            Seance::create([
                'duree_seance_id' => $dureeId,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }
    }
}
