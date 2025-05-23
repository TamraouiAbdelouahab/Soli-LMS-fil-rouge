<?php 

namespace Modules\PkgJustificatif\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PkgJustificatif\App\Models\Raison;

class RaisonSeeder extends Seeder
{
    public function run(): void
    {
        Raison::insert([
            [
                'id'   =>1,
                'code' => 'MAL',
                'title' => 'Maladie',
                'description' => 'Absence pour cause de maladie'
            ],
            [
                'id'   => 2,
                'code' => 'DEP',
                'title' => 'Déplacement',
                'description' => 'Absence liée à un déplacement professionnel ou personnel'
            ],
            [
                'id'   => 3,
                'code' => 'FAM',
                'title' => 'Raison familiale',
                'description' => 'Problème familial urgent'
            ]
        ]);
    }
}
