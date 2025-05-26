<?php

namespace Modules\PkgAbsence\App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\PkgAbsence\App\Models\Absence;

class AbsenceService
{
    public function getDashboardData()
    {
        return [
            // Cartes principales
            'totalAbsences' => $this->getTotalAbsences(),
            'todayAbsences' => $this->getTodayAbsences(),
            'weeklyAbsences' => $this->getWeeklyAbsences(),
            'monthlyAbsences' => $this->getMonthlyAbsences(),
            
            // Données pour les graphiques
            'weeklyChart' => $this->getWeeklyChartData(),
            'monthlyChart' => $this->getMonthlyChartData(),
            
            // Données pour les listes
            'recentAbsences' => $this->getRecentAbsences(),
            'topAbsentees' => $this->getTopAbsentees(),

            // Données pour l'export
            'exportData' => $this->getExportData()
        ];
    }

    public function getTotalAbsences()
    {
        return Absence::count();
    }

    public function getTodayAbsences()
    {
        return Absence::whereDate('date_absence', Carbon::today())->count();
    }

    public function getWeeklyAbsences()
    {
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();
        return Absence::whereBetween('date_absence', [$weekStart, $weekEnd])->count();
    }

    public function getMonthlyAbsences()
    {
        $monthStart = Carbon::now()->startOfMonth();
        $monthEnd = Carbon::now()->endOfMonth();
        return Absence::whereBetween('date_absence', [$monthStart, $monthEnd])->count();
    }

    public function getWeeklyChartData()
    {
        $days = collect(range(6, 0))->map(function ($day) {
            $date = Carbon::now()->subDays($day);
            return [
                'date' => $date->format('Y-m-d'),
                'label' => $date->format('D'),
            ];
        });

        $absences = Absence::whereIn(DB::raw('DATE(date_absence)'), $days->pluck('date'))
            ->select(DB::raw('DATE(date_absence) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        return [
            'labels' => $days->pluck('label'),
            'datasets' => [
                [
                    'label' => 'Absences',
                    'data' => $days->map(function ($day) use ($absences) {
                        return $absences[$day['date']] ?? 0;
                    }),
                    'borderColor' => '#3B82F6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'tension' => 0.4
                ]
            ]
        ];
    }

    public function getMonthlyChartData()
    {
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();
        $days = collect(range(0, $end->diffInDays($start)))
            ->map(function ($day) use ($start) {
                $date = $start->copy()->addDays($day);
                return [
                    'date' => $date->format('Y-m-d'),
                    'label' => $date->format('d M'),
                ];
            });

        $absences = Absence::whereMonth('date_absence', Carbon::now()->month)
            ->select(DB::raw('DATE(date_absence) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        return [
            'labels' => $days->pluck('label'),
            'datasets' => [
                [
                    'label' => 'Absences par jour',
                    'data' => $days->map(function ($day) use ($absences) {
                        return $absences[$day['date']] ?? 0;
                    }),
                    'borderColor' => '#10B981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'tension' => 0.4
                ]
            ]
        ];
    }

    public function getRecentAbsences()
    {
        return DB::table('absences')
            ->join('seances', 'absences.seance_id', '=', 'seances.id')
            ->select(
                'absences.id',
                'absences.date_absence',
                'seances.id as seance_id',
                DB::raw('DATE(absences.created_at) as created_date')
            )
            ->orderBy('absences.created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($absence) {
                return [
                    'id' => $absence->id,
                    'date' => Carbon::parse($absence->date_absence)->format('d/m/Y'),
                    'seance_id' => $absence->seance_id,
                    'created_at' => Carbon::parse($absence->created_date)->format('d/m/Y')
                ];
            });
    }

    public function getTopAbsentees()
    {
        return DB::table('absences')
            ->select('apprenant_id', DB::raw('COUNT(*) as total_absences'))
            ->whereMonth('date_absence', Carbon::now()->month)
            ->groupBy('apprenant_id')
            ->orderByDesc('total_absences')
            ->limit(5)
            ->get()
            ->map(function ($record) {
                return [
                    'apprenant_id' => $record->apprenant_id,
                    'total' => $record->total_absences
                ];
            });
    }

    public function getExportData()
    {
        return DB::table('absences')
            ->join('seances', 'absences.seance_id', '=', 'seances.id')
            ->leftJoin('users as apprenants', 'absences.apprenant_id', '=', 'apprenants.id')
            ->select(
                'absences.id',
                'absences.date_absence',
                'apprenants.email as apprenant_email',
                'seances.id as seance_id',
                'seances.duree_seance_id',
                'absences.created_at',
                'absences.updated_at'
            )
            ->orderBy('absences.date_absence', 'desc')
            ->get()
            ->map(function ($absence) {
                return [
                    'ID' => $absence->id,
                    'Date Absence' => Carbon::parse($absence->date_absence)->format('d/m/Y'),
                    'Apprenant' => $absence->apprenant_email,
                    'Séance ID' => $absence->seance_id,
                    'Durée Séance' => $absence->duree_seance_id,
                    'Créé le' => Carbon::parse($absence->created_at)->format('d/m/Y H:i'),
                    'Mis à jour le' => Carbon::parse($absence->updated_at)->format('d/m/Y H:i')
                ];
            });
    }

    public function getAbsencesByDateRange($startDate, $endDate)
    {
        return DB::table('absences')
            ->join('seances', 'absences.seance_id', '=', 'seances.id')
            ->leftJoin('users as apprenants', 'absences.apprenant_id', '=', 'apprenants.id')
            ->whereBetween('date_absence', [$startDate, $endDate])
            ->select(
                'absences.*',
                'apprenants.email as apprenant_email'
            )
            ->orderBy('date_absence', 'desc')
            ->get();
    }
}