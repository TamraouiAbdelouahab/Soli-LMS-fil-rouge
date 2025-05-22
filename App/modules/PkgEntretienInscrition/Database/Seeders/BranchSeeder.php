<?php

namespace  modules\PkgEntretienInscrition\Database\Seeders;

use Illuminate\Database\Seeder;
use modules\PkgEntretienInscrition\App\Models\Branch;

class BranchSeeder extends Seeder
{
    public function run()
    {
        $branches = [
            [
                'name' => 'French'
            ],
            [
                'name' => 'English'
            ],
            [
                'name' => 'Soft Skills'
            ],
            [
                'name' => 'Teamwork'
            ],
            [
                'name' => 'Front end'
            ],
            [
                'name' => 'Back end'
            ]
        ];

        foreach ($branches as $branch) {
            Branch::create($branch);
        }
    }
}
