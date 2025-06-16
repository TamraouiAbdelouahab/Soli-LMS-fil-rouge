<?php

namespace Modules\pkgAbsence\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PkgAbsence\App\Models\Absence;
use Carbon\Carbon;

class AbsencesSeeder1 extends Seeder
{
    public function run()
    {
        $absences = [];
        $now = Carbon::now();

        // Generate 40 non-justified, non-sanctioned absences
        for ($i = 0; $i < 40; $i++) {
            $absences[] = [
                'apprenant_id' => rand(1, 10),
                'user_id' => 2,
                'seance_id' => rand(1, 30),
                'justifie' => false,
                'est_sanctionnée' => false,
                'sanction_absence_id' => null,
                'sanction_absence_calculee_id' => null,
                'created_at' => $now->copy()->subDays(rand(0, 90)),
                'updated_at' => $now->copy()->subDays(rand(0, 90)),
            ];
        }

        foreach ($absences as $absence) {
            Absence::create($absence);
        }
    }
}
