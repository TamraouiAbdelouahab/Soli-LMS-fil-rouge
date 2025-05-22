<?php

namespace  modules\PkgEntretienInscrition\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use modules\PkgEntretienInscrition\App\Models\Branch;
use modules\PkgEntretienInscrition\App\Models\Interview;

class InterviewBranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = Branch::all();
        $interviews = Interview::all();

        for ($i = 0; $i < $branches->count(); $i++) {
            $branches[$i]->interviews()->attach($interviews[0]->id);
        }
    }
}
