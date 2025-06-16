<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seance;
use Carbon\Carbon;

class SeancesSeeder extends Seeder
{
    public function run()
    {
        $seances = [];
        $startDate = Carbon::now()->startOfWeek(); // Start from Monday of current week

        // Daily session time slots (3 sessions per day)
        $dailySlots = [
            ['start' => '09:00', 'end' => '11:00'],   // Morning session
            ['start' => '11:30', 'end' => '14:00'],  // Midday session
            ['start' => '14:30', 'end' => '17:00']   // Afternoon session
        ];

        // Create sessions for 10 weekdays (Monday-Friday across 2 weeks)
        $createdDays = 0;
        $dayOffset = 0;

        while ($createdDays < 10) {
            $currentDate = $startDate->copy()->addDays($dayOffset);
            $dayOffset++;

            // Skip weekends
            if ($currentDate->isWeekend()) {
                continue;
            }

            // Create 3 sessions for this weekday
            foreach ($dailySlots as $slot) {
                $seances[] = [
                    'date_debut' => $currentDate->copy()->setTimeFromTimeString($slot['start']),
                    'date_fin' => $currentDate->copy()->setTimeFromTimeString($slot['end']),
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            $createdDays++;
        }

        // Insert all seances
        Seance::insert($seances);
    }
}
