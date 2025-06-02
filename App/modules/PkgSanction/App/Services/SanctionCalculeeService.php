<?php

namespace Modules\PkgSanction\App\Services;

use Modules\PkgSanction\App\Models\SanctionAbsenceCalculee;

class SanctionCalculeeService
{
    public function getSanctionsCalculees()
    {
        $SanctionsCalculees = SanctionAbsenceCalculee::with('absences.apprenant.groupes', 'regle')->orderBy('updated_at', 'desc')->paginate(10);
        return $SanctionsCalculees;
    }
}
