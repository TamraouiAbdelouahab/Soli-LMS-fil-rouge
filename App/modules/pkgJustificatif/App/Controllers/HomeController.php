<?php

namespace Modules\PkgJustificatif\App\Controllers;

use Inertia\Inertia;
use Modules\Core\App\Controllers\BaseController;
use Modules\PkgJustificatif\App\Services\justificatifService;

class HomeController extends  BaseController
{
    protected $justificationService;

    public function __construct(justificatifService $justificationService)
    {
        $this->justificationService = $justificationService;
    }
    public function index()
    {
        return Inertia::render('PkgJustificatif::Home', [
            'justifications'=> $this->justificationService->Alljustifications(),
        ]);
    }
}


