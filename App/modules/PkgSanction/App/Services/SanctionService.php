<?php

namespace Modules\PkgSanction\App\Services;

use Carbon\Carbon;
use Modules\PkgSanction\App\Models\SanctionAbsence;
use Modules\PkgSanction\App\Models\SanctionAbsencePrevisionnelle;

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

    public function sanctionAbsencePrevisionnelleCount()
    {
        return SanctionAbsencePrevisionnelle::count();
    }
}
