<?php

namespace Modules\PkgJustificatif\App\Controllers;

use Inertia\Inertia;
use Modules\Core\App\Controllers\BaseController;
use Modules\PkgApprenant\App\Services\groupeService;
use Modules\PkgJustificatif\App\Services\justificatifService;
use Modules\PkgJustificatif\App\Services\raisonService;

class DashboardController extends  BaseController
{
    protected $justificationService,$raisonService,$groupeService;

    public function __construct(justificatifService $justificationService,raisonService $raisonService,groupeService $groupeService)
    {
        $this->justificationService = $justificationService;
        $this->raisonService = $raisonService;
        $this->groupeService = $groupeService;
        $this->middleware(['auth', 'verified', 'role:responsable des apprenants|responsable de formation']);
    }
    public function index()
    {
        return Inertia::render('PkgJustificatif::Dashboard', [
            'justifications'=> $this->justificationService->Alljustifications(),
            'apprenants' => $this->justificationService->ApprenantswithJustifications(),
            'countapprenant' => $this->justificationService->countapprenantwithjustification(),
            'reasons' =>$this->raisonService->Allreason(),
            'groups' => $this->groupeService->Allgroups(),
        ]);
    }
}


