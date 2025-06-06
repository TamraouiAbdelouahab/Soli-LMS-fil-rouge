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
                'est_sanctionnée' => false,
                'sanction_absence_id' => null,
                'sanction_absences_calculees_id' => null,
            ],
            [
                'apprenant_id' => 1,
                'user_id' => 2,
                'seance_id' => 2,
                'justifie' => true,
                'est_sanctionnée' => false,
                'sanction_absence_id' => null,
                'sanction_absences_calculees_id' => null,
            ],
            [
                'apprenant_id' => 2,
                'user_id' => 2,
                'seance_id' => 1,
                'justifie' => false,
                'est_sanctionnée' => false,
                'sanction_absence_id' => 1,
                'sanction_absences_calculees_id' => null,
            ],
            [
                'apprenant_id' => 2,
                'user_id' => 2,
                'seance_id' => 2,
                'justifie' => false,
                'est_sanctionnée' => false,
                'sanction_absence_id' => 2,
                'sanction_absences_calculees_id' => null,
            ],
            [
                'apprenant_id' => 3,
                'user_id' => 2,
                'seance_id' => 3,
                'justifie' => false,
                'est_sanctionnée' => false,
                'sanction_absence_id' => 2,
                'sanction_absences_calculees_id' => null,
            ]

        ];

        foreach ($absences as $absence) {
            Absence::create($absence);
        }
    }
}
