<?php

namespace Database\Seeders;

use App\Models\JustificationAbsence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JustificationAbsenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JustificationAbsence::insert([
            [
                'absence_id' => 1,

                'description' => 'Justification médicale pour absence.',
                'date_justified' => now(),
                'justification_file' => 'justification_medicale.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'absence_id' => 2,
                'type' => 'Personnel',
                'description' => 'Justification personnelle pour absence.',
                'date_justified' => now(),
                'justification_file' => 'justification_personnelle.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
