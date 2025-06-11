<?php

namespace Modules\PkgSanction\App\Services;

use Carbon\Carbon;
use Modules\PkgApprenant\App\Models\Apprenant;
use Modules\PkgSanction\App\Models\SanctionAbsence;
use Modules\PkgSanction\App\Models\SanctionAbsenceCalculee;
use Illuminate\Http\Request;

class SanctionService
{
    public function getRecentSanctions()
    {

        $RecentSanctions = SanctionAbsence::with('absences.apprenant', 'regle')->limit(5)->orderBy('date_fin', 'desc')->get();

        foreach ($RecentSanctions as $Sanction) {
            if ($Sanction) {
                $Statut = Carbon::parse($Sanction->date_fin)->lt(Carbon::now()) ? 'Expirée' : 'Active';
                $Sanction->statut = $Statut;
            }
        }

        return $RecentSanctions;
    }

    public function recentSanctionsCount()
    {
        $RecentSanctionsCount = SanctionAbsence::where('date_fin', '>=', Carbon::now()->subDays(7))->count();
        return $RecentSanctionsCount;
    }

    public function activeSanctionCount()
    {
        return SanctionAbsence::where('date_fin', '>=', Carbon::now())->count();
    }

    public function sanctionAbsenceCount()
    {
        return SanctionAbsence::count();
    }

    public function sanctionAbsenceCalculeeCount()
    {
        return SanctionAbsenceCalculee::count();
    }

    public function learnersSanctionedCount()
    {
        $learnersSanctionedCount = Apprenant::whereHas('absences', function ($query) {
            $query->whereNotNull('sanction_absence_id');
        })->distinct()->count('id');

        return $learnersSanctionedCount;
    }

    public function getSanctionsApplied(Request $request)
    {
        $query = SanctionAbsence::with(['absences.apprenant.groupes', 'regle']);
        $now = Carbon::now();

        // Status filter
        if ($request->filled('status_type')) {
            switch ($request->status_type) {
                case 'active':
                    $query->where('date_fin', '>=', $now)
                        ->where('lifted', false);
                    break;
                case 'expired':
                    $query->where('date_fin', '<', $now)
                        ->where('lifted', false);
                    break;
                case 'lifted':
                    $query->where('lifted', true);
                    break;
            }
        }

        // Group filter - fixed ambiguous column issue
        if ($request->filled('groupe_id')) {
            $query->whereHas('absences.apprenant.groupes', function ($q) use ($request) {
                $q->where('groupes.id', $request->groupe_id); // Explicitly specify table
            });
        }

        return $query->orderBy('date_fin', 'desc')->paginate(10);
    }
}
