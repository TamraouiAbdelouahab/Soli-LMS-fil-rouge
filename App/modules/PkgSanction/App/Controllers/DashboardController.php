<?php

namespace Modules\PkgSanction\App\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Core\App\Controllers\BaseController;
use Modules\PkgSanction\App\Services\SanctionChartService;
use Modules\PkgSanction\App\Services\SanctionService;

class DashboardController extends BaseController
{
    protected $sanctionService;
    protected $sanctionChartService;

    public function __construct(SanctionService $sanctionService, SanctionChartService $sanctionChartService)
    {
        $this->sanctionService = $sanctionService;
        $this->sanctionChartService = $sanctionChartService;
    }

    public function index()
    {
        // dd($this->sanctionService->totalSanctionAbsence());

        return Inertia::render('PkgSanction::Dashboard', [
            'sanctionsAbsenceCount' => $this->sanctionService->sanctionAbsenceCount(),
            'sanctionsAbsenceCalculeeCount' => $this->sanctionService->sanctionAbsenceCalculeeCount(),
            'recentSanctions' => $this->sanctionService->getRecentSanctions(),
            'recentSanctionsCount' => $this->sanctionService->recentSanctionsCount(),
            'activeSanctionCount' => $this->sanctionService->activeSanctionCount(),
            'monthlySanctions' => $this->sanctionChartService->getMonthlySanctions(),
            'sanctionsByTypes' => $this->sanctionChartService->getSanctionsByTypes(),
            'learnersSanctionedCount' => $this->sanctionService->learnersSanctionedCount(),
        ]);
    }
}
