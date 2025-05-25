<?php

namespace Modules\PkgJustificatif\App\Controllers;

use Inertia\Inertia;
use Modules\Core\App\Controllers\BaseController;
use Modules\PkgJustificatif\App\Services\justificatifService;

class DashboardController extends  BaseController
{
    protected $justificationService;

    public function __construct(justificatifService $justificationService)
    {
        $this->justificationService = $justificationService;
    }
    public function index()
    {
        return Inertia::render('PkgJustificatif::Dashboard', [
            'justifications'=> $this->justificationService->Alljustifications(),
            'apprenants' => $this->justificationService->ApprenantswithJustifications(),
        ]);
    }
}


