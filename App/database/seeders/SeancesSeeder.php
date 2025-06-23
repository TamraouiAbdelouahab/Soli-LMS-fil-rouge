<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seance;
use Carbon\Carbon;

class SeancesSeeder extends Seeder
{
    public function run()
    {
        $today = Carbon::today();

        $seances = [
            [
                'date_debut' => $today->copy()->setTime(9, 0),
                'date_fin'   => $today->copy()->setTime(11, 15),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'date_debut' => $today->copy()->setTime(11, 30),
                'date_fin'   => $today->copy()->setTime(14, 0),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'date_debut' => $today->copy()->setTime(14, 30),
                'date_fin'   => $today->copy()->setTime(17, 0),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        Seance::insert($seances);
    }
}
