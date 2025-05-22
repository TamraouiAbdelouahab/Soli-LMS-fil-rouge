<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Absence;

class AbsencesSeeder extends Seeder
{
    public function run()
    {
        // Absence::truncate();

        // Bob Martin = user_id 2, Claire Bernard = id 3
        Absence::insert([
            [
                'user_id' => 2,
                'seance_id' => 1,
                'sanction_absence_id' => null,
                'sanction_absence_previsionnelle_id' => null,
                'created_at' => now()->subDays(9),
                'updated_at' => now()
            ],
            [
                'user_id' => 2,
                'seance_id' => 1,
                'sanction_absence_id' => null,
                'sanction_absence_previsionnelle_id' => null,
                'created_at' => now()->subDays(9),
                'updated_at' => now()
            ],
            [
                'user_id' => 2,
                'seance_id' => 1,
                'sanction_absence_id' => 1,
                'sanction_absence_previsionnelle_id' => null,
                'created_at' => now()->subDays(10),
                'updated_at' => now()
            ],
            [
                'user_id' => 2,
                'seance_id' => 2,
                'sanction_absence_id' => 2,
                'sanction_absence_previsionnelle_id' => null,
                'created_at' => now()->subDays(9),
                'updated_at' => now()
            ],
            [
                'user_id' => 3,
                'seance_id' => 2,
                'sanction_absence_id' => null,
                'sanction_absence_previsionnelle_id' => 1,
                'created_at' => now()->subDays(5),
                'updated_at' => now()
            ],
            [
                'user_id' => 3,
                'seance_id' => 3,
                'sanction_absence_id' => null,
                'sanction_absence_previsionnelle_id' => 2,
                'created_at' => now()->subDays(4),
                'updated_at' => now()
            ],
        ]);
    }
}
