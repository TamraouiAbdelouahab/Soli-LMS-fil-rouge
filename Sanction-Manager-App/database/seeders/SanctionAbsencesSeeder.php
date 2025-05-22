<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PkgSanction\App\Models\SanctionAbsence;

class SanctionAbsencesSeeder extends Seeder
{
    public function run()
    {
        // SanctionAbsence::truncate();

        SanctionAbsence::create([
            'regle_de_sanction_id' => 1,
            'date_debut'           => now(),
            'date_fin'             => now()->subDays(0),
        ]);

        SanctionAbsence::create([
            'regle_de_sanction_id' => 2,
            'date_debut'           => now(),
            'date_fin'             => now()->subDays(2),
        ]);

        SanctionAbsence::create([
            'regle_de_sanction_id' => 3,
            'date_debut'           => now(),
            'date_fin'             => now()->subDays(0),
        ]);
    }
}
