<?php

namespace Modules\PkgSanction\App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\PkgAbsence\App\Models\Absence;
use Modules\PkgSanction\App\Models\ReglesDeSanction;
use Modules\PkgSanction\App\Models\SanctionAbsence;
use Modules\PkgSanction\App\Models\SanctionAbsenceCalculee;

class SanctionCalculeeService
{
    public function getSanctionsCalculees()
    {
        $SanctionsCalculees = SanctionAbsenceCalculee::with('absences.apprenant.groupes', 'regle')->orderBy('updated_at', 'desc')->paginate(10);
        return $SanctionsCalculees;
    }

    public function calculateSanctions()
    {
        // Step 0: Reset old data
        Absence::whereNotNull('sanction_absence_calculee_id')->update([
            'sanction_absence_calculee_id' => null,
        ]);
        SanctionAbsenceCalculee::query()->delete();
        DB::statement('ALTER TABLE sanction_absences_calculees AUTO_INCREMENT = 1');

        // Step 1: Get non-sanctioned, non-justified absences
        $AbsencesNonSanctionnees = Absence::where('est_sanctionnée', false)
            ->where('justifie', false)
            ->orderBy('created_at', 'asc')
            ->get()
            ->groupBy('apprenant_id');

        // Step 2: Get rules (from smallest to largest)
        $regles = ReglesDeSanction::orderBy('absences_max')->get();

        // Step 3: Loop over each learner
        foreach ($AbsencesNonSanctionnees as $apprenant_id => $absences) {
            $remainingAbsences = $absences;

            foreach ($regles as $regle) {
                // Check if enough absences to apply this rule
                if ($remainingAbsences->count() >= $regle->absences_max) {
                    // Take the needed number of absences
                    $subset = $remainingAbsences->take($regle->absences_max);

                    // Create sanction
                    $sanction = SanctionAbsenceCalculee::create([
                        'regle_de_sanction_id' => $regle->id,
                    ]);

                    // Link absences to the sanction
                    foreach ($subset as $absence) {
                        $absence->update([
                            'sanction_absence_calculee_id' => $sanction->id,
                        ]);
                    }

                    // Remove used absences from the list
                    $remainingAbsences = $remainingAbsences->slice($regle->absences_max);
                }
            }
        }
    }

    public function deleteSanctionCalculee($id)
    {
        $sanction = SanctionAbsenceCalculee::findOrFail($id);
        $sanction->absences()->update(['sanction_absence_calculee_id' => null]);
        $sanction->delete();
    }

    public function applicationSanction($sanctionId)
    {
        DB::transaction(function () use ($sanctionId) {
            // 1. Fetch the calculated sanction with absences and the rule
            $sanctionCalculee = SanctionAbsenceCalculee::with(['absences', 'regle'])->findOrFail($sanctionId);
            $absences = $sanctionCalculee->absences;
            $regle = $sanctionCalculee->regle;

            if ($absences->isEmpty()) {
                throw new \Exception("No absences found for this sanction.");
            }

            // 2. Get start date as now, and calculate end date using rule duration
            $startDate = Carbon::now();
            $endDate = $startDate->copy()->addDays($regle->duree_sanction);

            // 3. Create a new applied sanction
            $sanction = SanctionAbsence::create([
                'date_debut' => $startDate,
                'date_fin' => $endDate,
                'regle_de_sanction_id' => $regle->id,
            ]);

            // 4. Update each absence to link to the applied sanction
            foreach ($absences as $absence) {
                $absence->update([
                    'sanction_absence_id' => $sanction->id,
                    'est_sanctionnée' => true,
                    'sanction_absence_calculee_id' => null,
                ]);
            }

            // 5. Delete the calculated sanction
            $sanctionCalculee->delete();
        });
    }
}
