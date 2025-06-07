<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seance;
use Carbon\Carbon;

class SeancesSeeder extends Seeder
{
    public function run()
    {
        Seance::create([
            'date_debut' => Carbon::now()->setTime(9, 0), // date_debut : 9h00 aujourd'hui - date_fin : 11h15 aujourd'hui
            'date_fin'   => Carbon::now()->setTime(11, 15),
        ]);

        Seance::create([
            'date_debut' => Carbon::now()->setTime(11, 35), // date_debut : 11h35 aujourd'hui - date_fin : 13h50 aujourd'hui
            'date_fin'   => Carbon::now()->setTime(13, 50),
        ]);

        Seance::create([
            'date_debut' => Carbon::now()->setTime(14, 45), // date_debut : 14h45 demain - date_fin : 17h00 demain
            'date_fin'   => Carbon::now()->setTime(17, 0),
        ]);
    }
}
