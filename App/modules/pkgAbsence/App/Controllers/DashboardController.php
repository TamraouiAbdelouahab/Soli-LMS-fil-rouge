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
        return Inertia::render('pkgAbsence::Dashboard', $this->absenceService->getDashboardData());
    }
}
