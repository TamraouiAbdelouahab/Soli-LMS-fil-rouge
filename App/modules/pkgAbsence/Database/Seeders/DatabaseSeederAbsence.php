<?php

namespace Modules\PkgAbsence\Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeederAbsence extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Appel des seeders dans l'ordre logique
        $this->call([
            AbsencesSeeder::class,   
        ]);
    }
}
