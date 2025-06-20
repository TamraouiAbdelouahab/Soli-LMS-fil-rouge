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
use Illuminate\Support\Facades\URL;
use Modules\PkgApprenant\App\Services\apprenantService;

class JustificationController extends  BaseController
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
         $query = Justificatif::query()->with('raison', 'apprenant.groupes');
        // Filtres dynamiques
        if ($request->filled('apprenant_id')) {
            $query->where('apprenant_id', $request->apprenant_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('dateDebut')) {
            $query->whereDate('created_at', '>=', $request->dateDebut);
        }

        if ($request->filled('dateFin')) {
            $query->whereDate('created_at', '<=', $request->dateFin);
        }
        return Inertia::render('PkgJustificatif::Home', [
            // 'justifications'=> $this->justificationService->Alljustifications(),
            'justifications' => $query->paginate(5)->appends($request->query()),
            'reasons' =>$this->raisonService->Allreason(),
            'groups' => $this->groupeService->Allgroups(),
            'apprenants' => $this->apprenantService->Allgroups(),
            // Filtres conservés dans le formulaire Vue
            'filters'     => $request->only(['apprenant_id', 'status', 'dateDebut', 'dateFin']),
        ]);
    }
    public function store(StoreJustificationRequest $request)
    {
        $validateData = $request->validated();
        $originalName = $request->file('fichier')->getClientOriginalName();
        $timestamp = now()->format('YmdHis');
        $newFileName = $timestamp . '_' . $originalName;
        $path = $request->file('fichier')->storeAs('justifications', $newFileName, 'public');
        $data = array_merge($validateData,['raison_id'=>$validateData['raison'],'apprenant_id'=>$validateData['apprenant'],'fichier' => $path,]);
        $this->justificationService->create($data);
    }

    public function update($id,UpdateJustificationRequest $request)
    {
        $validateData = $request->validated();
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
        $data = array_merge($validateData,['raison_id'=>$validateData['raison'],'apprenant_id'=>$validateData['apprenant'],'fichier' => $path,]);
        $this->justificationService->update($id,$data);
    }
    public function destroy($id)
    {
        $this->justificationService->delete($id);
        if(str_contains(url()->previous(), 'justificatif/dashboard')){
            return Redirect::route('Justificatifs.dashboard');
        }
        elseif(str_contains(url()->previous(), 'justificatif/home')){
            return Redirect::route('Justificatifs.home');
        }

        // return Redirect::route('Justificatifs.home');
        // return Inertia::redirect()->route('Justificatifs.home');
    }
}

