<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Core\Database\Seeders\UsersTableSeeder;
use Modules\PkgApprenant\Database\Seeders\GroupeSeeder;
use Modules\PkgApprenant\Database\Seeders\ApprenantSeeder;
use Modules\PkgSanction\Database\Seeders\NotificationsSeeder;
use Modules\PkgApprenant\Database\Seeders\ApprenantGroupeSeeder;
use Modules\PkgSanction\Database\Seeders\SanctionAbsencesSeeder;
use Modules\PkgSanction\Database\Seeders\ReglesDeSanctionsSeeder;
use Modules\PkgSanction\Database\Seeders\SanctionAbsencesPrevisionnellesSeeder;
use modules\PkgEntretienInscrition\Database\Seeders\PkgEntretienInscritionDatabaseSeeder;

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
            UsersTableSeeder::class,
            GroupeSeeder::class,
            ApprenantSeeder::class,
            ApprenantGroupeSeeder::class,
            ReglesDeSanctionsSeeder::class,
            DureeSeancesSeeder::class,
            SeancesSeeder::class,
            SanctionAbsencesSeeder::class,
            SanctionAbsencesPrevisionnellesSeeder::class,
            AbsencesSeeder::class,
            JustificationAbsenceSeeder::class,
            NotificationsSeeder::class,
            PkgEntretienInscritionDatabaseSeeder::class
        ]);
    }
}
