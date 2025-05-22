<?php

namespace modules\PkgEntretienInscrition\Database\Seeders;

use Illuminate\Database\Seeder;
use modules\PkgEntretienInscrition\App\Models\Candidate;

class CandidateSeeder extends Seeder
{
  public function run()
  {
    $names = [
      'Alice Martin',
      'Bob Dupont',
      'Charlie Durand',
      'Dana Leroy',
      'Evelyn Smith',
      'François Moreau',
      'Gabriel Bernard',
      'Hannah Leroy',
      'Isabelle Doe',
      'Julien Petit',
      'Karim Haddad',
      'Laura Dubois',
      'Nadia Roux',
      'Olivier Blanc',
      'Pauline Roy',
      'Quentin Rousseau',
      'Rania Kheir',
      'Samuel Girard',
      'Tara Michel',
      'Victor Leroy',
    ];

    foreach ($names as $name) {
      Candidate::create(['name' => $name]);
    }
  }
}
