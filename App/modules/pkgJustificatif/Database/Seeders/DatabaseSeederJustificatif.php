<?php

namespace Modules\PkgJustificatif\Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeederJustificatif extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Appel des seeders dans l'ordre logique
        $this->call([
            RaisonSeeder::class,   
            JustificatifSeeder::class,
        ]);
    }
}
