<?php

namespace Modules\pkgAbsence\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PkgAbsence\App\Models\Absence;

class AbsencesSeeder extends Seeder
{
    public function run()
    {
        // Absence::truncate();

        // Bob Martin = user_id 2, Claire Bernard = id 3
        Absence::insert([
            [
                'apprenant_id' => 2,
                'seance_id' => 1,
                'sanction_absence_id' => null,
                'sanction_absence_previsionnelle_id' => null,
                'date_absence' => now()->subDays(rand(0, 30))->toDateString(),
                'created_at' => now()->subDays(9),
                'updated_at' => now()
            ],
            [
                'apprenant_id' => 2,
                'seance_id' => 1,
                'sanction_absence_id' => null,
                'sanction_absence_previsionnelle_id' => null,
                'date_absence' => now()->subDays(rand(0, 30))->toDateString(),
                'created_at' => now()->subDays(9),
                'updated_at' => now()
            ],
            [
                'apprenant_id' => 2,
                'seance_id' => 1,
                'sanction_absence_id' => 1,
                'sanction_absence_previsionnelle_id' => null,
                'date_absence' => now()->subDays(rand(0, 30))->toDateString(),
                'created_at' => now()->subDays(10),
                'updated_at' => now()
            ],
            [
                'apprenant_id' => 2,
                'seance_id' => 2,
                'sanction_absence_id' => 2,
                'sanction_absence_previsionnelle_id' => null,
                'date_absence' => now()->subDays(rand(0, 30))->toDateString(),

                'created_at' => now()->subDays(9),
                'updated_at' => now()
            ],
            [
                'apprenant_id' => 3,
                'seance_id' => 2,
                'sanction_absence_id' => null,
                'sanction_absence_previsionnelle_id' => 1,
                'date_absence' => now()->subDays(rand(0, 30))->toDateString(),
                'created_at' => now()->subDays(5),
                'updated_at' => now()
            ],
            [
                'apprenant_id' => 3,
                'seance_id' => 3,
                'sanction_absence_id' => null,
                'sanction_absence_previsionnelle_id' => 2,
                'date_absence' => now()->subDays(rand(0, 30))->toDateString(),
                'created_at' => now()->subDays(4),
                'updated_at' => now()
            ],
        ]);
    }
}
