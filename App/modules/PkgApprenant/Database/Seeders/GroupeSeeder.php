<?php

namespace Modules\PkgApprenant\Database\Seeders;

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
                'nom' => 'DW 101',
                'description' => 'Groupe des apprenants de la première année.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nom' => 'DW 102',
                'description' => 'Groupe des apprenants de la première année.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
                        [
                'nom' => 'DW 103',
                'description' => 'Groupe des apprenants de la première année.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
                        [
                'nom' => 'DW 104',
                'description' => 'Groupe des apprenants de la première année.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nom' => 'DM 101',
                'description' => 'Groupe des apprenants de la deuxième année.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
