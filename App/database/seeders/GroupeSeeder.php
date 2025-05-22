<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PkgApprenant\App\Models\Groupe;
use Carbon\Carbon;

class GroupeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Groupe::insert([
            [
                'nom' => 'Groupe A',
                'description' => 'Groupe des apprenants de la première année.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nom' => 'Groupe B',
                'description' => 'Groupe des apprenants spécialisés en développement web.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nom' => 'Groupe C',
                'description' => 'Groupe des apprenants de la deuxième année.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
