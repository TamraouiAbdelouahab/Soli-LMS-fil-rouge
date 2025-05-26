<?php

namespace Modules\pkgAbsence\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PkgAbsence\App\Models\Absence;
use Modules\PkgApprenant\App\Models\Apprenant;
use App\Models\Seance;
use Carbon\Carbon;
use Faker\Factory as Faker;

class AbsencesSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('fr_FR');
        
        // Get all students and sessions
        $apprenants = Apprenant::all();
        $seances = Seance::all();
        
        // Generate data for the last 3 months
        $startDate = Carbon::now()->subMonths(3)->startOfMonth();
        $endDate = Carbon::now();
        
        $currentDate = $startDate->copy();
        
        while ($currentDate <= $endDate) {
            // Skip weekends
            if ($currentDate->isWeekend()) {
                $currentDate->addDay();
                continue;
            }
            
            // For each session of the day (3 sessions)
            foreach ($seances as $seance) {
                // Randomly select 10-30% of students who will be absent
                $absentCount = rand(
                    ceil($apprenants->count() * 0.10),
                    ceil($apprenants->count() * 0.30)
                );
                
                // Randomly select students for this session
                $absentStudents = $apprenants->random($absentCount);
                
                foreach ($absentStudents as $student) {
                    // Create absence record
                    $absence = new Absence([
                        'apprenant_id' => $student->id,
                        'seance_id' => $seance->id,
                        'date_absence' => $currentDate->format('Y-m-d'),
                    ]);
                    
                    // 60% chance of having a sanction or justification
                    if ($faker->boolean(60)) {
                        // 40% chance of being justified
                        if ($faker->boolean(40)) {
                            // Will be linked to justification through the justificatifs table
                            $absence->save();
                            
                            // Create justification in JustificatifSeeder
                        } else {
                            // Add sanction
                            $absence->sanction_absence_id = rand(1, 3); // Assuming you have 3 types of sanctions
                        }
                    } else {
                        // 20% chance of having a provisional sanction
                        if ($faker->boolean(20)) {
                            $absence->sanction_absence_previsionnelle_id = rand(1, 2);
                        }
                    }
                    
                    $absence->save();
                }
            }
            
            $currentDate->addDay();
        }

    }
} 