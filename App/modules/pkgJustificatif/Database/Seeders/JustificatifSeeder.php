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
                'fichier' => 'justifications/00010101010101_IMAGE01.png',
                'description' => 'Grippe saisonnière',
                'status' => 'ACCEPTE',
                'raison_id' => 1,
                'apprenant_id' => 1,
            ],
            [
                'dateDepot' => Carbon::now()->subDays(1),
                'DateDebut' => Carbon::now()->subDays(3),
                'DateFin' => Carbon::now()->subDays(2),
                'fichier' => 'justifications/00010101010101_IMAGE02.png',
                'description' => 'Déplacement familial urgent',
                'status' => 'EN_ATTENTE',
                'raison_id' => 2,
                'apprenant_id' => 1,
            ],
            [
                'dateDepot' => Carbon::now()->subDays(3),
                'DateDebut' => Carbon::now()->subDays(7),
                'DateFin' => Carbon::now()->subDays(6),
                'fichier' => 'justifications/00010101010101_IMAGE03.png',
                'description' => 'Absence pour mariage d’un proche',
                'status' => 'ACCEPTE',
                'raison_id' => 3,
                'apprenant_id' => 2,
            ],
            [
                'dateDepot' => Carbon::now()->subDays(5),
                'DateDebut' => Carbon::now()->subDays(10),
                'DateFin' => Carbon::now()->subDays(9),
                'fichier' => 'justifications/00010101010101_IMAGE04.png',
                'description' => 'Consultation médicale',
                'status' => 'REJETE',
                'raison_id' => 1,
                'apprenant_id' => 3,
            ],
            [
                'dateDepot' => Carbon::now(),
                'DateDebut' => Carbon::now()->subDays(1),
                'DateFin' => Carbon::now(),
                'fichier' => 'justifications/00010101010101_IMAGE05.png',
                'description' => 'Décès d’un membre de la famille',
                'status' => 'EN_ATTENTE',
                'raison_id' => 3,
                'apprenant_id' => 2,
            ],
        ];

        foreach ($justificatifs as $data) {
            Justificatif::create($data);
        }
    }
}
