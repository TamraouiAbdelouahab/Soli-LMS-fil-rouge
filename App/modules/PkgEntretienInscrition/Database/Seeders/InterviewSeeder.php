<?php

namespace  modules\PkgEntretienInscrition\Database\Seeders;

use Illuminate\Database\Seeder;
use modules\PkgEntretienInscrition\App\Models\Interview;

class InterviewSeeder extends Seeder
{
    public function run()
    {
        $interviews = [
            [
                'title' => 'Interview 1',
            ],
            [
                'title' => 'Interview 2'
            ],
        ];

        foreach ($interviews as $interview) {
            Interview::create($interview);
        }
    }
}
