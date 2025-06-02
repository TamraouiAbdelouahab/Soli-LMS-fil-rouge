<?php

namespace Modules\PkgSanction\App\Controllers;

use Inertia\Inertia;
use Modules\Core\App\Controllers\BaseController;
use Modules\PkgSanction\App\Services\SanctionService;

class SanctionCalculeController extends BaseController
{
    protected $sanctionService;

    public function __construct(SanctionService $sanctionService)
    {
        $this->sanctionService = $sanctionService;
    }

    public function index()
    {
        return Inertia::render('PkgSanction::SanctionTracking', [
            'sanctionsApplied' => $this->sanctionService->getSanctionsApplied(),
        ]);
    }
}
