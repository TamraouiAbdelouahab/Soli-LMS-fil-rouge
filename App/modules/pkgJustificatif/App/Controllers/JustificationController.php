<?php

namespace Modules\PkgJustificatif\App\Controllers;

use Inertia\Inertia;
use Modules\Core\App\Controllers\BaseController;
use Modules\PkgApprenant\App\Services\groupeService;
use Modules\PkgJustificatif\App\Services\justificatifService;
use Modules\PkgJustificatif\App\Services\raisonService;
use Modules\PkgJustificatif\App\Requests\JustificationRequest;
class JustificationController extends  BaseController
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
    public function store(JustificationRequest $request)
    {
        $validateData = $request->validated();
        $data = array_merge($validateData,['raison_id'=>$validateData['raison'],'apprenant_id'=>$validateData['apprenant']]);
        $justification = $this->justificationService->create($data);
        // return Inertia::redirect('Justificatifs.home');
    }

    public function update($id,JustificationRequest $request)
    {
        $validateData = $request->validated();
        $justification = $this->justificationService->update($id,$validateData);
        return Inertia::redirect('Justificatifs.home');
    }
    public function destroy($id)
    {
        $justification = $this->justificationService->delete($id);
        // return Inertia::redirect('Justificatifs.home');
    }
}

