<?php

namespace Modules\PkgJustificatif\App\Controllers;

use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Modules\Core\App\Controllers\BaseController;
use Modules\PkgApprenant\App\Services\groupeService;
use Modules\PkgJustificatif\App\Models\Raison;
use Modules\PkgJustificatif\App\Services\justificatifService;
use Modules\PkgJustificatif\App\Services\raisonService;
use Modules\PkgJustificatif\App\Requests\ReasonRequest;

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
    public function store(ReasonRequest $request)
    {
        $validateData = $request->validated();
        $this->raisonService->create($validateData);
    }
    public function destroy($id)
    {
        $this->raisonService->delete($id);
        return Redirect::route('reasons.home');
    }
}

