<?php

namespace Modules\PkgSanction\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PkgSanction\App\Models\ReglesDeSanction;

class ReglesDeSanctionsSeeder extends Seeder
{
    public function run()
    {
        // RegleDeSanction::truncate();

        ReglesDeSanction::insert([
            [
                'titre'                 => 'Avertissement après 3 absences',
                'description'           => 'Envoi d\'un e-mail d\'avertissement',
                'absences_max'          => 3,
                'penalite'              => 'avertissement',
                'seuil_de_notification' => 2,
                'duree'                 => 0,
                'note'                  => 'Appliqué sur une semaine glissante',
                'created_at'            => now(),
                'updated_at'            => now(),
            ],
            [
                'titre'                 => 'Suspension après 5 absences',
                'description'           => 'Suspension de l\'accès pendant 1 mois',
                'absences_max'          => 5,
                'penalite'              => 'suspension',
                'seuil_de_notification' => 4,
                'duree'                 => 2,
                'note'                  => 'Notification 3 jours avant',
                'created_at'            => now(),
                'updated_at'            => now(),
            ],
            [
                'titre'                 => 'Exclusion après 10 absences',
                'description'           => 'Exclusion définitive',
                'absences_max'          => 10,
                'penalite'              => 'exclusion',
                'seuil_de_notification' => 8,
                'duree'                 => 0,
                'note'                  => 'Notification immédiate',
                'created_at'            => now(),
                'updated_at'            => now(),
            ],
        ]);
    }
}
