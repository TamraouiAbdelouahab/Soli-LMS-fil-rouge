<?php

namespace Modules\PkgApprenant\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PkgApprenant\App\Models\Apprenant;
use Modules\PkgApprenant\App\Models\Groupe;

class ApprenantGroupeSeeder extends Seeder
{
    public function run(): void
    {
        $apprenants = Apprenant::all();
        $groupes = Groupe::all();

        foreach ($apprenants as $apprenant) {
            $randomGroupes = $groupes->random(rand(1, min(1, $groupes->count())))->pluck('id')->toArray();
            $apprenant->groupes()->sync($randomGroupes);
        }
    }
}
