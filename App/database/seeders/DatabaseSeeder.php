<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Modules\Core\App\Models\User;
use Modules\Core\Database\Seeders\DatabaseSeederCore;
use Modules\PkgJustificatif\Database\Seeders\DatabaseSeederJustificatif;
use Modules\PkgEntretienInscrition\Database\Seeders\PkgEntretienInscritionDatabaseSeeder;
use Modules\PkgAbsence\Database\Seeders\DatabaseSeederAbsence;
use Modules\PkgApprenant\Database\Seeders\DatabaseSeederApprenant;
use Modules\PkgSanction\Database\Seeders\DatabaseSeederSanction;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            DatabaseSeederCore::class,
            DatabaseSeederApprenant::class,
            DatabaseSeederJustificatif::class,
            SeancesSeeder::class,
            DatabaseSeederSanction::class,
            DatabaseSeederAbsence::class,
            PkgEntretienInscritionDatabaseSeeder::class
        ]);
    }
}
