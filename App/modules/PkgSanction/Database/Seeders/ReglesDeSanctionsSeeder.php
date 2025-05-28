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
                'titre'                 => 'Avertissement',
                'description'           => 'Envoi d\'un e-mail d\'avertissement',
                'absences_max'          => 3,
                'seuil_de_notification' => 2,
                'duree_sanction'        => 0,
                'est_actif'             => true,
                'created_at'            => now(),
                'updated_at'            => now(),
            ],
            [
                'titre'                 => 'Suspension',
                'description'           => 'Suspension de l\'accès pendant 1 mois',
                'absences_max'          => 5,
                'seuil_de_notification' => 4,
                'duree_sanction'        => 2,
                'est_actif'             => true,
                'created_at'            => now(),
                'updated_at'            => now(),
            ],
            [
                'titre'                 => 'Exclusion',
                'description'           => 'Exclusion définitive',
                'absences_max'          => 10,
                'seuil_de_notification' => 8,
                'duree_sanction'        => 0,
                'est_actif'             => true,
                'created_at'            => now(),
                'updated_at'            => now(),
            ],
        ]);
    }
}
