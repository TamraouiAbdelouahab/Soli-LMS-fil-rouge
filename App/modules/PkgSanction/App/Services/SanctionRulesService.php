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
        return DB::transaction(function () use ($id, $data) {
            $rule = ReglesDeSanction::findOrFail($id);
            $rule->update($data);
            return $rule;
        });
    }

    public function deleteSanctionRule($id)
    {
        return DB::transaction(function () use ($id) {
            $rule = ReglesDeSanction::findOrFail($id);
            $rule->delete();
            return true;
        });
    }

    public function toggleStatus($id)
    {
        return DB::transaction(function () use ($id) {
            $rule = ReglesDeSanction::findOrFail($id);
            $rule->est_actif = !$rule->est_actif;
            $rule->save();

            return $rule;
        });
    }
}
