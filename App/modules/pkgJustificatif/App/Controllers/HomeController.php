<?php

namespace Modules\PkgJustificatif\App\Controllers;

use Inertia\Inertia;
use Modules\Core\App\Controllers\BaseController;
use Modules\PkgApprenant\App\Services\groupeService;
use Modules\PkgJustificatif\App\Services\justificatifService;
use Modules\PkgJustificatif\App\Services\raisonService;

class HomeController extends  BaseController
{
    protected $justificationService,$raisonService,$groupeService;

    public function __construct(justificatifService $justificationService,raisonService $raisonService,groupeService $groupeService)
    {
        $this->justificationService = $justificationService;
        $this->raisonService = $raisonService;
        $this->groupeService = $groupeService;
    }
    public function index()
    {
        return Inertia::render('PkgJustificatif::Home', [
            'justifications'=> $this->justificationService->Alljustifications(),
            'reasons' =>$this->raisonService->Allreason(),
            'groups' => $this->groupeService->Allgroups(),
        ]);
    }
}


