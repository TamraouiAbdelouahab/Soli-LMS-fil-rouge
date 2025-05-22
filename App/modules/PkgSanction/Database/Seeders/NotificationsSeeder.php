<?php

namespace Modules\PkgSanction\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PkgSanction\App\Models\Notification;

class NotificationsSeeder extends Seeder
{
    public function run()
    {
        // Notification::truncate();

        Notification::insert([
            [
                'sanction_absence_id' => 1,
                'apprenant_id'             => 2,
                'message'             => 'Vous avez dépassé votre quota d\'absences autorisées.',
                'created_at'          => now()->subDays(6),
                'updated_at'          => now(),
            ],
            [
                'sanction_absence_id' => 2,
                'apprenant_id'             => 3,
                'message'             => 'Votre accès est suspendu pour une durée de 4 jours.',
                'created_at'          => now()->subDays(2),
                'updated_at'          => now(),
            ],
        ]);
    }
}
