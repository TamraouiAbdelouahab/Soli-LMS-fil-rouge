<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PkgApprenant\App\Models\Apprenant;
use Modules\Core\App\Models\User;
use Carbon\Carbon;

class ApprenantSeeder extends Seeder
{
    public function run(): void
    {
        // Get users by email to associate with apprenants
        $user1 = User::where('email', 'ahmed.elamrani@gmail.com')->first();
        $user2 = User::where('email', 'fatimazahra.boulahdour@gmail.com')->first();
        $user3 = User::where('email', 'youssef.benjelloun@gmail.com')->first();
        $user4 = User::where('email', 'souad.amrani@gmail.com')->first();

        Apprenant::create([
            'user_id' => $user1->id,
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
            'user_id' => $user2->id,
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
            'user_id' => $user3->id,
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

        Apprenant::create([
            'user_id' => $user4->id,
            'nom' => 'El Amrani',
            'prenom' => 'Souad',
            'prenom_arab' => 'سعاد',
            'nom_arab' => 'العمري',
            'tele_num' => '0654321098',
            'profile_image' => 'default.png',
            'date_inscription' => Carbon::now()->subMonths(1),
            'cin' => 'GH901234',
            'adresse' => 'Fes, Maroc',
        ]);
    }
}
