<?php

namespace Modules\PkgSanction\App\Services;

use App\Models\Absence;
use Carbon\Carbon;
use Modules\PkgSanction\App\Models\SanctionAbsence;
use Modules\PkgSanction\App\Models\SanctionAbsencePrevisionnelle;

class SanctionService
{
    public function getRecentSanctions()
    {
        $RecentSanctions = Absence::with('apprenant', 'sanctionAbsence.regle')->whereNotNull('sanction_absence_id')->get();

        foreach ($RecentSanctions as $RecentSanction) {
            $SanctionAbsence = $RecentSanction->sanction_absence;

            if ($SanctionAbsence) {
                $Statut = Carbon::parse($SanctionAbsence->date_fin)->lt(Carbon::now()) ? 'Terminée' : 'En cours';
            }
        }


        return $RecentSanctions;
    }

    public function totalSanctionAbsence()
    {
        return SanctionAbsence::count();
    }

    public function totalSanctionAbsencePrevisionnelle()
    {
        return SanctionAbsencePrevisionnelle::count();
    }
}
