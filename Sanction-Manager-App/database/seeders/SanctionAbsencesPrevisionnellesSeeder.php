<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PkgSanction\App\Models\SanctionAbsencePrevisionnelle;

class SanctionAbsencesPrevisionnellesSeeder extends Seeder
{
    public function run()
    {
        // SanctionAbsencePrevisionnelle::truncate();

        SanctionAbsencePrevisionnelle::insert([
            ['regle_de_sanction_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            ['regle_de_sanction_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
        ]);
    }
}
