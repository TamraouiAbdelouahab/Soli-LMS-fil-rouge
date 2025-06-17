<?php

namespace Modules\PkgJustificatif\App\Controllers;

use Inertia\Inertia;
use Modules\Core\App\Controllers\BaseController;
use Modules\PkgApprenant\App\Services\groupeService;
use Modules\PkgJustificatif\App\Models\Raison;
use Modules\PkgJustificatif\App\Services\justificatifService;
use Modules\PkgJustificatif\App\Services\raisonService;
class raisonController extends  BaseController
{
    protected $raisonService;


    public function __construct(raisonService $raisonService){
        $this->raisonService = $raisonService;
    }
    public function index()
    {
        return Inertia::render('PkgJustificatif::Reason', [
            'reasons' => Raison::paginate(5),
        ]);
    }
}

