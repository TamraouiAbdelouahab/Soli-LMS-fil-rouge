<?php

namespace Modules\PkgAbsence\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\pkgAbsence\Database\Seeders\AbsencesSeeder1;

class DatabaseSeederAbsence extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Appel des seeders dans l'ordre logique
        $this->call([
            AbsencesSeeder1::class,   
        ]);
    }
}
