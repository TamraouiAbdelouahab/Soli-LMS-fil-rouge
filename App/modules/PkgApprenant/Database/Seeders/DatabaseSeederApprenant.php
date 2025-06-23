<?php

namespace Modules\PkgApprenant\Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeederApprenant extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            GroupeSeeder::class,
            ApprenantSeeder::class,
            ApprenantGroupeSeeder::class,
        ]);
    }
}
