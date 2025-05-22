<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PkgApprenant\App\Models\Apprenant;
use Carbon\Carbon;

class ApprenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Apprenant::create([
            'nom' => 'El Amrani',
            'prenom' => 'Youssef',
            'prenom_arab' => 'يوسف',
            'nom_arab' => 'العمري',
            'tele_num' => '0612345678',
            'profile_image' => 'default.png',
            'date_inscription' => Carbon::now()->subMonths(6),
            'cin' => 'AB123456',
            'adresse' => 'Rabat, Maroc',
        ]);

        Apprenant::create([
            'nom' => 'Benali',
            'prenom' => 'Sara',
            'prenom_arab' => 'سارة',
            'nom_arab' => 'بن علي',
            'tele_num' => '0698765432',
            'profile_image' => 'default.png',
            'date_inscription' => Carbon::now()->subMonths(4),
            'cin' => 'CD789012',
            'adresse' => 'Casablanca, Maroc',
        ]);

        Apprenant::create([
            'nom' => 'Tazi',
            'prenom' => 'Omar',
            'prenom_arab' => 'عمر',
            'nom_arab' => 'تازي',
            'tele_num' => '0677889900',
            'profile_image' => 'default.png',
            'date_inscription' => Carbon::now()->subMonths(2),
            'cin' => 'EF345678',
            'adresse' => 'Tanger, Maroc',
        ]);
    }
}
