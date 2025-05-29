<?php

namespace Modules\pkgAbsence\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PkgAbsence\App\Models\Absence;

class AbsencesSeeder1 extends Seeder
{
    public function run()
    {
        // Absence::truncate();

        $absences = [
            [
                'apprenant_id' => 1,
                'user_id' => 2,
                'seance_id' => 1,
                'justifie' => false,
                'sanction_absence_id' => null,
                'sanction_absence_previsionnelle_id' => null,
            ],
            [
                'apprenant_id' => 1,
                'user_id' => 2,
                'seance_id' => 2,
                'justifie' => true,
                'sanction_absence_id' => null,
                'sanction_absence_previsionnelle_id' => null,
            ],
            [
                'apprenant_id' => 2,
                'user_id' => 2,
                'seance_id' => 1,
                'justifie' => false,
                'sanction_absence_id' => 1,
                'sanction_absence_previsionnelle_id' => null,
            ],
            [
                'apprenant_id' => 2,
                'user_id' => 2,
                'seance_id' => 2,
                'justifie' => false,
                'sanction_absence_id' => 2,
                'sanction_absence_previsionnelle_id' => null,
            ],
            [
                'apprenant_id' => 3,
                'user_id' => 2,
                'seance_id' => 3,
                'justifie' => false,
                'sanction_absence_id' => 2,
                'sanction_absence_previsionnelle_id' => null,
            ]

        ];

        foreach ($absences as $absence) {
            Absence::create($absence);
        }
    }
}
