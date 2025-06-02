<?php

namespace Modules\PkgSanction\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PkgSanction\App\Models\SanctionAbsenceCalculee;

class SanctionAbsencesCalculeesSeeder extends Seeder
{
    public function run()
    {
        // SanctionAbsencePrevisionnelle::truncate();

        SanctionAbsenceCalculee::insert([
            ['regle_de_sanction_id'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            ['regle_de_sanction_id'=>2, 'created_at'=>now(), 'updated_at'=>now()],
        ]);
    }
}
