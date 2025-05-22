<?php

namespace Modules\PkgSanction\App\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Core\App\Controllers\BaseController;
use Modules\PkgSanction\App\Services\SanctionService;

class DashboardController extends BaseController
{
    protected $sanctionService;

    public function __construct(SanctionService $sanctionService)
    {
        $this->sanctionService = $sanctionService;
    }

    public function index()
    {
        // dd($this->sanctionService->totalSanctionAbsence());

        return Inertia::render('PkgSanction::Dashboard', [
            'sanctionsAbsenceCount' => $this->sanctionService->totalSanctionAbsence()
        ]);
    }
}
