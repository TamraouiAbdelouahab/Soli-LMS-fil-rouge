<?php

namespace  Modules\PkgEntretienInscrition\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\PkgEntretienInscrition\App\Models\Branch;
use Modules\PkgEntretienInscrition\App\Models\Interview;

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
