<?php

namespace Modules\PkgSanction\App\Services;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\PkgAbsence\App\Models\Absence;
use Modules\PkgSanction\App\Models\ReglesDeSanction;
use Modules\PkgSanction\App\Models\SanctionAbsence;
use Modules\PkgSanction\App\Models\SanctionAbsenceCalculee;
use Modules\PkgSanction\App\Notifications\AbsenceWarningNotification;
use Modules\PkgSanction\App\Notifications\SanctionAppliedNotification;

class SanctionCalculeeService
{
    public function getSanctionsCalculees(Request $request)
    {
        $query = SanctionAbsenceCalculee::with(['absences.apprenant.groupes', 'regle']);

        if ($request->filled('sanction_type')) {
            $query->whereHas('regle', function ($q) use ($request) {
                $q->where('sanction_type', $request->sanction_type);
            });
        }

        // Group filter - fixed ambiguous column issue
        if ($request->filled('groupe_id')) {
            $query->whereHas('absences.apprenant.groupes', function ($q) use ($request) {
                $q->where('groupes.id', $request->groupe_id);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('absences.apprenant', function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                    ->orWhere('prenom', 'like', "%{$search}%");
            });
        }

        return $query->paginate(10, ['*'], 'pending_page')
            ->appends($request->only(['sanction_type', 'groupe_id', 'search']));;
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
            $sanctionCalculee = SanctionAbsenceCalculee::with(['absences.apprenant.user', 'regle'])->findOrFail($sanctionId);
            $absences = $sanctionCalculee->absences;
            $regle = $sanctionCalculee->regle;
            $apprenant = $absences->first()?->apprenant->user;

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

            // send the notification
            if ($apprenant) {
                $apprenant->notify(new SanctionAppliedNotification($sanction));
            }
        });
    }

    public function sanctionAbsenceCalculeeCount()
    {
        return SanctionAbsenceCalculee::count();
    }

    public function calculateWarnings()
    {
        $warningRule = ReglesDeSanction::orderBy('seuil_de_notification')->first();
        if (!$warningRule) {
            return;
        }

        $warningThreshold = $warningRule->seuil_de_notification;

        // Group absences by learner where absence is not justified and not sanctioned
        $absencesGrouped = Absence::where('est_sanctionnée', false)
            ->where('justifie', false)
            ->get()
            ->groupBy('apprenant_id');

        foreach ($absencesGrouped as $apprenant_id => $absences) {
            $count = $absences->count();

            if ($count >= $warningThreshold) {
                $user = $absences->first()->apprenant->user;

                if ($user) {
                    // Avoid sending duplicate unread notifications
                    $alreadyWarned = $user->notifications()
                        ->where('type', AbsenceWarningNotification::class)
                        ->whereNull('read_at')
                        ->exists();

                    if (!$alreadyWarned) {
                        $user->notify(new AbsenceWarningNotification($count, $warningThreshold));
                    }
                }
            }
        }
    }
}
