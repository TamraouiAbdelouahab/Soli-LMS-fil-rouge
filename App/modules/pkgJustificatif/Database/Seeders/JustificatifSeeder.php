<?php

namespace Modules\PkgJustificatif\Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Modules\PkgJustificatif\App\Models\Justificatif;

class JustificatifSeeder extends Seeder
{
    public function run(): void
    {
        $justificatifs = [
            [
                'dateDepot' => Carbon::now()->subDays(2),
                'DateDebut' => Carbon::now()->subDays(5),
                'DateFin' => Carbon::now()->subDays(3),
                'fichier' => 'maladie1.pdf',
                'description' => 'Grippe saisonnière',
                'statut' => 'ACCEPTE',
                'raison_id' => 1,
                'apprenant_id' => 1,
            ],
            [
                'dateDepot' => Carbon::now()->subDays(1),
                'DateDebut' => Carbon::now()->subDays(3),
                'DateFin' => Carbon::now()->subDays(2),
                'fichier' => 'deplacement1.pdf',
                'description' => 'Déplacement familial urgent',
                'statut' => 'EN_ATTENTE',
                'raison_id' => 2,
                'apprenant_id' => 1,
            ],
            [
                'dateDepot' => Carbon::now()->subDays(3),
                'DateDebut' => Carbon::now()->subDays(7),
                'DateFin' => Carbon::now()->subDays(6),
                'fichier' => 'justificatif3.pdf',
                'description' => 'Absence pour mariage d’un proche',
                'statut' => 'ACCEPTE',
                'raison_id' => 3,
                'apprenant_id' => 2,
            ],
            [
                'dateDepot' => Carbon::now()->subDays(5),
                'DateDebut' => Carbon::now()->subDays(10),
                'DateFin' => Carbon::now()->subDays(9),
                'fichier' => 'maladie2.pdf',
                'description' => 'Consultation médicale',
                'statut' => 'REJETE',
                'raison_id' => 1,
                'apprenant_id' => 3,
            ],
            [
                'dateDepot' => Carbon::now(),
                'DateDebut' => Carbon::now()->subDays(1),
                'DateFin' => Carbon::now(),
                'fichier' => 'famille1.pdf',
                'description' => 'Décès d’un membre de la famille',
                'statut' => 'EN_ATTENTE',
                'raison_id' => 3,
                'apprenant_id' => 2,
            ],
        ];

        foreach ($justificatifs as $data) {
            Justificatif::create($data);
        }
    }
}
