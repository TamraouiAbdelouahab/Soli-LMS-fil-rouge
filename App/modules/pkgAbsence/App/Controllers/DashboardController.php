<?php

namespace Modules\PkgAbsence\App\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Core\App\Controllers\BaseController;
use Modules\PkgAbsence\App\Services\DashboardService;
use Modules\PkgApprenant\App\Models\Apprenant;
use App\Models\Seance;
use Carbon\Carbon;
class DashboardController extends BaseController
{
    protected $absenceService;

    public function __construct(DashboardService $absenceService)
    {
        $this->absenceService = $absenceService;
    }

    public function index(Request $request)
    {
        $filterType = $request->input('filter_type', 'month'); // Default to 'month'
        $filterValue = $request->input('filter_value');

        // Set default filter value if not provided
        if (is_null($filterValue)) {
            $now = Carbon::now();
            switch ($filterType) {
                case 'today':
                case 'week':
                case 'month':
                    $filterValue = ($filterType === 'month') ? $now->month : null;
                    break;
                case 'year':
                    $filterValue = $now->year;
                    break;
                case 'custom_week':
                    $filterValue = $now->weekOfYear;
                    break;
                case 'custom_month':
                    $filterValue = $now->month;
                    break;
                case 'custom_year':
                    $filterValue = $now->year;
                    break;
            }
        }

        return Inertia::render('pkgAbsence::Dashboard', [
            'totalAbsencesToday' => $this->absenceService->getTotalAbsencesToday($filterType, $filterValue),
            'learnersAbsentToday' => $this->absenceService->getLearnersAbsentToday($filterType, $filterValue),
            'globalAbsenceRate' => $this->absenceService->getGlobalAbsenceRate($filterType, $filterValue),
            'absenceStats' => $this->absenceService->getAbsenceStats($filterType, $filterValue),
            'weeklyRecap' => $this->absenceService->getWeeklyRecap($filterType, $filterValue),
            'monthlyRecap' => $this->absenceService->getMonthlyRecap($filterType, $filterValue),
            'topGroups' => $this->absenceService->getTopGroups(5, $filterType, $filterValue),
            'topSessions' => $this->absenceService->getTopSessions(5, $filterType, $filterValue),
            'topMonthlyLearners' => $this->absenceService->getTopMonthlyLearners(5, $filterType, $filterValue),
            'apprenants' => Apprenant::select('id', 'nom', 'prenom', 'cin')->get(),
            'seances' => Seance::select('id', 'date_debut', 'date_fin')->get(),
            'currentFilter' => [
                'type' => $filterType,
                'value' => $filterValue,
            ],
        ]);
    }

    // You can add an update method if you need to edit absences
    // public function update(Request $request, Absence $absence)
    // {
    //     $request->validate([
    //         'justifie' => ['boolean'],
    //         // Add other fields if they can be updated
    //     ]);

    //     try {
    //         $absence->update($request->all());
    //         return redirect()->back()->with('success', 'Absence mise à jour avec succès.');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Erreur lors de la mise à jour de l\'absence: ' . $e->getMessage());
    //     }
    // }
}
