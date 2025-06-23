<?php
namespace Modules\pkgAbsence\App\Services;

use Carbon\Carbon;
use Modules\pkgAbsence\App\Models\Absence;
use Modules\PkgApprenant\App\Models\Apprenant;
use Modules\PkgApprenant\App\Models\Groupe;
use App\Models\Seance;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    /**
     * Applies date filtering to an Eloquent query builder.
     *
     * @param Builder $query
     * @param string|null $filterType
     * @param mixed $filterValue
     * @return Builder
     */
    protected function applyDateFilter(Builder $query, ?string $filterType, $filterValue): Builder
    {
        $now = Carbon::now();

        // Explicitly qualify 'created_at' with the 'absences' table
        $column = 'absences.created_at';

        switch ($filterType) {
            case 'today':
                $query->whereDate($column, $now->toDateString());
                break;
            case 'week':
                $query->whereBetween($column, [$now->startOfWeek(), $now->endOfWeek()]);
                break;
            case 'month':
                $query->whereMonth($column, $now->month)->whereYear($column, $now->year);
                break;
            case 'year':
                $query->whereYear($column, $now->year);
                break;
            case 'custom_week':
                if ($filterValue) {
                    // Assuming filterValue is the week number (1-52)
                    // This might need adjustment based on your specific week definition (ISO vs US)
                    $year = $now->year; // Or pass year as another filter param
                    $startOfWeek = Carbon::parse("{$year}-01-01")->addWeeks($filterValue - 1)->startOfWeek();
                    $endOfWeek = Carbon::parse("{$year}-01-01")->addWeeks($filterValue - 1)->endOfWeek();
                    $query->whereBetween($column, [$startOfWeek, $endOfWeek]);
                }
                break;
            case 'custom_month':
                if ($filterValue) {
                    // Assuming filterValue is the month number (1-12)
                    $query->whereMonth($column, $filterValue)->whereYear($column, $now->year);
                }
                break;
            case 'custom_year':
                if ($filterValue) {
                    // Assuming filterValue is the year (e.g., 2023)
                    $query->whereYear($column, $filterValue);
                }
                break;
            default:
                // Default to current month if no filter or invalid filter
                $query->whereMonth($column, $now->month)->whereYear($column, $now->year);
                break;
        }
        return $query;
    }

    public function getTotalAbsencesToday(?string $filterType = null, $filterValue = null): int
    {
        $query = Absence::query();
        $this->applyDateFilter($query, $filterType, $filterValue);
        return $query->count();
    }

    public function getLearnersAbsentToday(?string $filterType = null, $filterValue = null): int
    {
        $query = Absence::query();
        $this->applyDateFilter($query, $filterType, $filterValue);
        return $query->distinct('user_id')->count('user_id');
    }

    public function getGlobalAbsenceRate(?string $filterType = null, $filterValue = null): float
    {
        $totalApprenants = Apprenant::count(); // This should ideally be total active learners for the period
        if ($totalApprenants === 0) {
            return 0.0;
        }
        $learnersAbsent = $this->getLearnersAbsentToday($filterType, $filterValue); // Renamed to be more general
        return round(($learnersAbsent / $totalApprenants) * 100, 2);
    }

    public function getAbsenceStats(?string $filterType = null, $filterValue = null): array
    {
        $query = Absence::query();
        $this->applyDateFilter($query, $filterType, $filterValue);

        $total = $query->count();
        $justified = (clone $query)->where('justifie', true)->count();
        $unjustified = (clone $query)->where('justifie', false)->count();
        $sanctioned = (clone $query)->where('est_sanctionnée', true)->count();

        return [
            'total' => $total,
            'justified' => $justified,
            'unjustified' => $unjustified,
            'sanctioned' => $sanctioned,
        ];
    }

    public function getWeeklyRecap(?string $filterType = null, $filterValue = null): array
    {
        $query = Absence::select(
                DB::raw('DATE(absences.created_at) as day'), // Qualify here too for select
                DB::raw('COUNT(*) as total')
            );
        $this->applyDateFilter($query, $filterType, $filterValue);
        return $query->groupBy('day')->orderBy('day')->get()->toArray();
    }

    public function getMonthlyRecap(?string $filterType = null, $filterValue = null): array
    {
        $query = Absence::select(
                DB::raw('WEEK(absences.created_at) as week'), // Qualify here too for select
                DB::raw('COUNT(*) as total')
            );
        $this->applyDateFilter($query, $filterType, $filterValue);
        return $query->groupBy('week')->orderBy('week')->get()->toArray();
    }

    public function getTopGroups(int $limit = 5, ?string $filterType = null, $filterValue = null): array
    {
        $query = Groupe::select('groupes.nom', DB::raw('COUNT(absences.id) as total'))
            ->join('apprenant_groupe', 'groupes.id', '=', 'apprenant_groupe.groupe_id')
            ->join('apprenants', 'apprenants.id', '=', 'apprenant_groupe.apprenant_id')
            ->join('absences', 'apprenants.id', '=', 'absences.user_id');

        $this->applyDateFilter($query, $filterType, $filterValue);

        return $query->groupBy('groupes.nom')
            ->orderByDesc('total')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    public function getTopSessions(int $limit = 5, ?string $filterType = null, $filterValue = null): array
    {
        $query = Seance::select('seances.id', DB::raw('CONCAT("Séance ", DATE_FORMAT(seances.date_debut, " %H:%i")) as nom'), DB::raw('COUNT(absences.id) as total'))
            ->join('absences', 'seances.id', '=', 'absences.seance_id');

        $this->applyDateFilter($query, $filterType, $filterValue);

        return $query->groupBy('seances.id', 'seances.date_debut')
            ->orderByDesc('total')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    public function getTopMonthlyLearners(int $limit = 5, ?string $filterType = null, $filterValue = null): array
    {
        $query = Apprenant::select(
                'apprenants.id as apprenant_id',
                'apprenants.nom',
                'apprenants.prenom',
                'apprenants.prenom_arab',
                'apprenants.nom_arab',
                DB::raw('COUNT(absences.id) as total')
            )
            ->join('absences', 'apprenants.id', '=', 'absences.user_id');

        $this->applyDateFilter($query, $filterType, $filterValue);

        return $query->groupBy('apprenants.id', 'apprenants.nom', 'apprenants.prenom', 'apprenants.cin')
            ->orderByDesc('total')
            ->limit($limit)
            ->get()
            ->toArray();
    }
}
