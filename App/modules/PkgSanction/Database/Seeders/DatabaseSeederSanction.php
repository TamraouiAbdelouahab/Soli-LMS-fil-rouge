<?php

namespace Modules\PkgSanction\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Notifications\NotificationSender;

class DatabaseSeederSanction extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Appel des seeders dans l'ordre logique
        $this->call([
            ReglesDeSanctionsSeeder::class,
            // SanctionAbsencesCalculeesSeeder::class,
            // SanctionAbsencesSeeder::class,
            // NotificationsSeeder::class,
        ]);
    }
}
