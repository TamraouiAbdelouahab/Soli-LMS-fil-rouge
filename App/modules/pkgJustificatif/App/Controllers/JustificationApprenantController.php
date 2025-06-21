<?php

namespace Modules\PkgJustificatif\App\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Modules\Core\App\Controllers\BaseController;
use Modules\PkgApprenant\App\Services\groupeService;
use Modules\PkgJustificatif\App\Models\Justificatif;
use Modules\PkgJustificatif\App\Services\justificatifService;
use Modules\PkgJustificatif\App\Services\raisonService;
use Modules\PkgJustificatif\App\Requests\StoreJustificationRequest;
use Modules\PkgJustificatif\App\Requests\UpdateJustificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\PkgApprenant\App\Services\apprenantService;
use Illuminate\Support\Facades\Auth;
use Modules\PkgJustificatif\App\Requests\StoreJustificationByApprenantRequest;
use Modules\PkgJustificatif\App\Requests\UpdateJustificationByApprenantRequest;

class JustificationApprenantController extends  BaseController
{
    protected $justificationService,$raisonService,$groupeService,$apprenantService;

    public function __construct(justificatifService $justificationService,raisonService $raisonService,groupeService $groupeService,apprenantService $apprenantService)
    {
        $this->justificationService = $justificationService;
        $this->raisonService = $raisonService;
        $this->groupeService = $groupeService;
        $this->apprenantService = $apprenantService;
    }
     public function index(Request $request)
    {
         $query = Justificatif::query()->with('raison', 'apprenant.groupes')
         ->where('apprenant_id', Auth::user()->id);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('dateDebut')) {
            $query->whereDate('dateDebut', '>=', $request->dateDebut);
        }

        if ($request->filled('dateFin')) {
            $query->whereDate('dateFin', '<=', $request->dateFin);
        }
        return Inertia::render('PkgJustificatif::ApprenantJustification', [
            // 'justifications'=> $this->justificationService->Alljustifications(),
            'justifications' => $query->paginate(5)->appends($request->query()),
            'reasons' =>$this->raisonService->Allreason(),
            'groups' => $this->groupeService->Allgroups(),
            'apprenants' => $this->apprenantService->Allgroups(),
            // Filtres conservés dans le formulaire Vue
            'filters'     => $request->only(['apprenant_id', 'status', 'dateDebut', 'dateFin']),
        ]);
    }
    public function store(StoreJustificationByApprenantRequest $request)
    {
        $validateData = $request->validated();
        $originalName = $request->file('fichier')->getClientOriginalName();
        $timestamp = now()->format('YmdHis');
        $newFileName = $timestamp . '_' . $originalName;
        $path = $request->file('fichier')->storeAs('justifications', $newFileName, 'public');
        $path = 'justifications/' . $newFileName;
        $data = array_merge($validateData,['raison_id'=>$validateData['raison'],'apprenant_id'=>Auth::user()->id,'fichier' => $path,]);
        $this->justificationService->create($data);
    }
    public function update($id,UpdateJustificationByApprenantRequest $request)
    {
        $validateData = $request->validated();
        if ($this->justificationService->find($id)->status !== 'EN_ATTENTE') {
            return Redirect::back()->with(['messageErrorValideEnAttente' => 'Vous ne pouvez modifier une justification que si elle est en attente.']);
        }
        $path = "justifications/" . $request->file('fichier')->getClientOriginalName();
        if($path != Justificatif::find($id)->fichier){
            $originalName = $request->file('fichier')->getClientOriginalName();
            $timestamp = now()->format('YmdHis');
            $newFileName = $timestamp . '_' . $originalName;
            $path = $request->file('fichier')->storeAs('justifications', $newFileName, 'public');
            if (Justificatif::find($id)->fichier && Storage::disk('public')->exists(Justificatif::find($id)->fichier)) {
                Storage::disk('public')->delete(Justificatif::find($id)->fichier);
        }
        }
        $data = array_merge($validateData,['raison_id'=>$validateData['raison'],'fichier' => $path,]);
        $this->justificationService->update($id,$data);
    }
}

