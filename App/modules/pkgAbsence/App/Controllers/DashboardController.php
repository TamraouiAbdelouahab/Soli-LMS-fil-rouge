<?php

namespace Modules\PkgAbsence\App\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Core\App\Controllers\BaseController;
use Modules\PkgAbsence\App\Services\AbsenceService;

class DashboardController extends BaseController
{
    protected $absenceService;

    public function __construct(AbsenceService $absenceService)
    {
        $this->absenceService = $absenceService;
    }

    public function index()
    {
        try {
            // Données principales
            $totalAbsencesToday = $this->absenceService->totalAbsencesToday();
            $learnersAbsentToday = $this->absenceService->learnersAbsentToday();
            $globalAbsenceRate = $this->absenceService->globalAbsenceRate();

            // Top groupes aujourd'hui + ce mois
            $topGroups = $this->absenceService->topGroupsWithAbsents();
            $topGroupsMonthly = $this->absenceService->topGroupsWithAbsentsMonthly();

            // Top séances aujourd’hui
            $topSessions = $this->absenceService->topSessionsWithAbsents();

            // Apprenants les plus absents ce mois
            $topMonthlyLearners = $this->absenceService->topLearnersAbsentMonthly();

            // Récapitulatif semaine / mois
            $recapData = $this->absenceService->recapWeeklyMonthly();

            // Séances non traitées
            $unprocessedSessions = $this->absenceService->unprocessedSessions();

            // Statistiques supplémentaires
            $absenceStats = $this->absenceService->getAbsenceStats();

            return Inertia::render('pkgAbsence::Dashboard', [
                'totalAbsencesToday' => $totalAbsencesToday,
                'learnersAbsentToday' => $learnersAbsentToday,
                'globalAbsenceRate' => $globalAbsenceRate,

                'topGroups' => $topGroups,
                'topGroupsMonthly' => $topGroupsMonthly,

                'topSessions' => $topSessions,
                'topMonthlyLearners' => $topMonthlyLearners,

                'weeklyRecap' => $recapData['weekly'],
                'monthlyRecap' => $recapData['monthly'],

                'unprocessedSessions' => $unprocessedSessions,
                'absenceStats' => $absenceStats,
            ]);
        } catch (\Exception $e) {
            return Inertia::render('pkgAbsence::Dashboard', [
                'totalAbsencesToday' => 0,
                'learnersAbsentToday' => 0,
                'globalAbsenceRate' => 0,

                'topGroups' => [],
                'topGroupsMonthly' => [],
                'topSessions' => [],
                'topMonthlyLearners' => [],

                'weeklyRecap' => [],
                'monthlyRecap' => [],

                'unprocessedSessions' => [],
                'absenceStats' => [
                    'justified' => 0,
                    'unjustified' => 0,
                    'total' => 0,
                    'sanctioned' => 0,
                ],
            ]);
        }
    }
}
