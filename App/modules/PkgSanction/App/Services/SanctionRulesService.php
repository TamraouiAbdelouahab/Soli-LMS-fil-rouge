<?php

namespace Modules\PkgSanction\App\Services;

use Illuminate\Support\Facades\DB;
use Modules\PkgApprenant\App\Models\Apprenant;
use Modules\PkgSanction\App\Models\ReglesDeSanction;

class SanctionRulesService
{
    public function getSanctionRules()
    {
        $sanctionRules = ReglesDeSanction::all();
        return $sanctionRules;
    }

    public function rulesCount()
    {
        return ReglesDeSanction::count();
    }

    public function activeRulesCount()
    {
        return ReglesDeSanction::where('est_actif', true)->count();
    }

    public function learnersSanctionedCount()
    {
        $learnersSanctionedCount = Apprenant::whereHas('absences', function ($query) {
            $query->whereNotNull('sanction_absence_id');
        })->distinct()->count('id');

        return $learnersSanctionedCount;
    }

    public function getLastModificationDate()
    {
        $lastModification = ReglesDeSanction::orderBy('updated_at', 'desc')->first();
        return $lastModification ? $lastModification->updated_at : null;
    }

    public function createSanctionRule($data)
    {
        return DB::transaction(function () use ($data) {
            return ReglesDeSanction::create($data);
        });
    }

    public function updateSanctionRule($id, $data)
    {
        // This method should handle the update of an existing sanction rule.
        // For now, we will just return true as a placeholder.
        return true;
    }

    public function deleteSanctionRule($id)
    {
        // This method should handle the deletion of a sanction rule.
        // For now, we will just return true as a placeholder.
        return true;
    }
}
