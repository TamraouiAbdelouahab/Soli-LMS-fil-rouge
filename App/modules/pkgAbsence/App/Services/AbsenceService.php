<?php

namespace Modules\PkgAbsence\App\Services;

use Carbon\Carbon;
use Modules\PkgAbsence\App\Models\Absence;
use App\Models\Seance;
use Modules\PkgApprenant\App\Models\Groupe;
use Illuminate\Support\Facades\DB;

class AbsenceService
{
    public function getDashboardData(): array
    {
        $today = Carbon::today();
        $startOfWeek = $today->copy()->startOfWeek();
        $endOfWeek = $today->copy()->endOfWeek();

        // KPI 1 : Total des séances prévues
        $totalSeances = Seance::count();

        // KPI 2 : Séances avec absences saisies
        $seancesAvecAbsences = Absence::distinct()->pluck('seance_id')->count();

        // KPI 3 : Séances non traitées
        $seancesNonTraitees = $totalSeances - $seancesAvecAbsences;

        // KPI 4 : Absences saisies aujourd’hui
        $absencesAujourdhui = Absence::whereDate('created_at', $today)->count();

        // KPI 5 : Top 5 groupes avec plus d’absences
        $topGroupes = DB::table('absences')
            ->join('apprenants', 'absences.user_id', '=', 'apprenants.id')
            ->join('apprenant_groupe', 'apprenants.id', '=', 'apprenant_groupe.apprenant_id')
            ->join('groupes', 'apprenant_groupe.groupe_id', '=', 'groupes.id')
            ->select('groupes.nom', DB::raw('COUNT(absences.id) as total_absences'))
            ->groupBy('groupes.nom')
            ->orderByDesc('total_absences')
            ->limit(5)
            ->get();

        // KPI 6 : Évolution des absences cette semaine (chart ligne)
        $evolutionHebdo = Absence::whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // KPI 7 : Taux d’absentéisme global
        $totalAbsences = Absence::count();
        $totalApprenants = DB::table('apprenants')->count();
        $tauxAbsent = $totalSeances > 0 && $totalApprenants > 0
            ? round(($totalAbsences / ($totalSeances * $totalApprenants)) * 100, 2)
            : 0;

        return [
            'totalSeances' => $totalSeances,
            'seancesAvecAbsences' => $seancesAvecAbsences,
            'seancesNonTraitees' => $seancesNonTraitees,
            'absencesAujourdhui' => $absencesAujourdhui,
            'topGroupes' => $topGroupes,
            'evolutionHebdo' => $evolutionHebdo,
            'tauxAbsent' => $tauxAbsent,
        ];
    }
}
