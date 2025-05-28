<?php

namespace Modules\PkgSanction\App\Services;

use Illuminate\Support\Facades\DB;
use Modules\PkgSanction\App\Models\SanctionAbsence;

class SanctionChartService
{
    public function getMonthlySanctions()
    {
        // Fetch sanctions count grouped by month from DB
        $sanctions = SanctionAbsence::selectRaw("MONTH(created_at) as month, COUNT(*) as sanctions")
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $months = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];

        $result = [];

        foreach (range(1, 12) as $monthNumber) {
            $result[] = [
                'month' => $months[$monthNumber - 1],
                'count' => isset($sanctions[$monthNumber]) ? $sanctions[$monthNumber]->sanctions : 0,
            ];
        }

        return collect($result);
    }


    public function getSanctionsByTypes()
    {
        return SanctionAbsence::join('regles_de_sanctions', 'sanction_absences.regle_de_sanction_id', '=', 'regles_de_sanctions.id')
            ->select('regles_de_sanctions.titre', DB::raw('COUNT(*) as value'))
            ->groupBy('regles_de_sanctions.titre')
            ->get();
    }
}
