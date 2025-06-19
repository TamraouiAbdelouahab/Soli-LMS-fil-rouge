<?php

namespace Modules\PkgAbsence\App\Services;

use Carbon\Carbon;
use Modules\PkgAbsence\App\Models\Absence;
use Modules\PkgApprenant\App\Models\Apprenant;
use Illuminate\Support\Facades\DB;

class AbsenceService
{
    // 1. 🔢 Total des absences aujourd’hui
    public function totalAbsencesToday(): int
    {
        return Absence::whereHas('seance', function ($query) {
            $query->whereDate('date_debut', Carbon::today());
        })->count();
    }

    // 2. 👥 Nombre d'apprenants absents aujourd’hui
    public function learnersAbsentToday(): int
    {
        return Absence::whereHas('seance', function ($query) {
            $query->whereDate('date_debut', Carbon::today());
        })->distinct('apprenant_id')->count('apprenant_id');
    }

    // 3. 👤 Top 5 des apprenants les plus absents ce mois
    public function topLearnersAbsentMonthly()
    {
        return DB::table('absences')
            ->join('seances', 'absences.seance_id', '=', 'seances.id')
            ->join('apprenants', 'absences.apprenant_id', '=', 'apprenants.id')
            ->whereMonth('seances.date_debut', Carbon::now()->month)
            ->select(
                'absences.apprenant_id',
                'apprenants.nom',
                'apprenants.prenom',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('absences.apprenant_id', 'apprenants.nom', 'apprenants.prenom')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
    }

    // 4. 🏷️ Top 5 groupes avec le plus d'absents aujourd'hui
    public function topGroupsWithAbsents()
    {
        return DB::table('absences')
            ->join('seances', 'absences.seance_id', '=', 'seances.id')
            ->join('apprenants', 'absences.apprenant_id', '=', 'apprenants.id')
            ->join('apprenant_groupe', 'apprenants.id', '=', 'apprenant_groupe.apprenant_id')
            ->join('groupes', 'apprenant_groupe.groupe_id', '=', 'groupes.id')
            ->whereDate('seances.date_debut', Carbon::today())
            ->select('groupes.nom', DB::raw('COUNT(*) as total'))
            ->groupBy('groupes.nom')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
    }

    // 5. 🏷️ Top 5 groupes avec le plus d'absents ce mois
    public function topGroupsWithAbsentsMonthly()
    {
        return DB::table('absences')
            ->join('seances', 'absences.seance_id', '=', 'seances.id')
            ->join('apprenants', 'absences.apprenant_id', '=', 'apprenants.id')
            ->join('apprenant_groupe', 'apprenants.id', '=', 'apprenant_groupe.apprenant_id')
            ->join('groupes', 'apprenant_groupe.groupe_id', '=', 'groupes.id')
            ->whereMonth('seances.date_debut', Carbon::now()->month)
            ->select('groupes.nom', DB::raw('COUNT(*) as total'))
            ->groupBy('groupes.nom')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
    }

    // 6. 🕐 Séances avec le plus d'absents aujourd’hui
    public function topSessionsWithAbsents()
    {
        return DB::table('absences')
            ->join('seances', 'absences.seance_id', '=', 'seances.id')
            ->whereDate('seances.date_debut', Carbon::today())
            ->select('seances.date_debut', DB::raw('COUNT(*) as total'))
            ->groupBy('seances.date_debut')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
    }

    // 7. 📉 Taux d’absence global aujourd’hui (en %)
    public function globalAbsenceRate(): float
    {
        $totalLearners = Apprenant::count();
        $absents = $this->learnersAbsentToday();

        return $totalLearners > 0
            ? round(($absents / $totalLearners) * 100, 2)
            : 0;
    }

    // 8. 📊 Évolution hebdomadaire et mensuelle des absences
    public function recapWeeklyMonthly(): array
    {
        $weekly = DB::table('absences')
            ->join('seances', 'absences.seance_id', '=', 'seances.id')
            ->whereBetween('seances.date_debut', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->selectRaw('DATE(seances.date_debut) as day, COUNT(*) as total')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $monthly = DB::table('absences')
            ->join('seances', 'absences.seance_id', '=', 'seances.id')
            ->whereMonth('seances.date_debut', Carbon::now()->month)
            ->selectRaw('YEAR(seances.date_debut) as year, WEEK(seances.date_debut) as week, COUNT(*) as total')
            ->groupBy('year', 'week')
            ->orderBy('week')
            ->get();

        return [
            'weekly' => $weekly,
            'monthly' => $monthly,
        ];
    }

    // 9. 📅 Séances non traitées
    public function unprocessedSessions()
    {
        return DB::table('seances')
            ->leftJoin('absences', 'seances.id', '=', 'absences.seance_id')
            ->whereNull('absences.id')
            ->whereDate('seances.date_debut', '<=', Carbon::today())
            ->select('seances.id', 'seances.date_debut', 'seances.date_fin')
            ->orderBy('seances.date_debut', 'desc')
            ->limit(10)
            ->get();
    }

    // 10. 📈 Statistiques : justifiées / non justifiées / sanctionnées
    public function getAbsenceStats(): array
    {
        $todayStats = DB::table('absences')
            ->join('seances', 'absences.seance_id', '=', 'seances.id')
            ->whereDate('seances.date_debut', Carbon::today())
            ->selectRaw('
                SUM(CASE WHEN justifie = 1 THEN 1 ELSE 0 END) as justified,
                SUM(CASE WHEN justifie = 0 THEN 1 ELSE 0 END) as unjustified,
                COUNT(*) as total
            ')
            ->first();

        $sanctionedCount = Absence::whereHas('seance', function ($query) {
            $query->whereDate('date_debut', Carbon::today());
        })->where('est_sanctionnée', true)->count();

        return [
            'justified' => $todayStats->justified ?? 0,
            'unjustified' => $todayStats->unjustified ?? 0,
            'total' => $todayStats->total ?? 0,
            'sanctioned' => $sanctionedCount,
        ];
    }
}
