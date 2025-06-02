<?php

namespace Modules\PkgSanction\App\Controllers;

use Inertia\Inertia;
use Modules\Core\App\Controllers\BaseController;
use Modules\PkgSanction\App\Services\SanctionCalculeeService;
use Modules\PkgSanction\App\Services\SanctionService;

class SanctionController extends BaseController
{
    protected $sanctionService;
    protected $sanctionCalculeeService;

    public function __construct(SanctionService $sanctionService, SanctionCalculeeService $sanctionCalculeeService)
    {
        $this->sanctionService = $sanctionService;
        $this->sanctionCalculeeService = $sanctionCalculeeService;
    }

    public function index()
    {
        return Inertia::render('PkgSanction::SanctionTracking', [
            'sanctionsApplied' => $this->sanctionService->getSanctionsApplied(),
            'sanctionsCalculees' => $this->sanctionCalculeeService->getSanctionsCalculees(),
        ]);
    }
}
