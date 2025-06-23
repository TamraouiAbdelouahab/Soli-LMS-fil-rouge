<?php

namespace Modules\PkgJustificatif\App\Controllers;

use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Modules\Core\App\Controllers\BaseController;
use Modules\PkgJustificatif\App\Models\Raison;
use Modules\PkgJustificatif\App\Services\raisonService;
use Modules\PkgJustificatif\App\Requests\UpdateReasonRequest;
use Modules\PkgJustificatif\App\Requests\StoreReasonRequest;

class raisonController extends  BaseController
{
    protected $raisonService;


    public function __construct(raisonService $raisonService){
        $this->raisonService = $raisonService;
        $this->middleware(['auth', 'verified', 'role:responsable des apprenants|responsable de formation']);

    }
    public function index()
    {
        return Inertia::render('PkgJustificatif::Reason', [
            'reasons' => Raison::paginate(5),
        ]);
    }
    public function store(StoreReasonRequest $request)
    {
        $validateData = $request->validated();
        $this->raisonService->create($validateData);
    }
    public function update($id,UpdateReasonRequest $request)
    {
        $validateData = $request->validated();
        $this->raisonService->update($id,$validateData);
    }
    public function destroy($id)
    {
        $delete = $this->raisonService->delete($id);
        if (!$delete) {
        return response()->json(
            [
                'message' => "Impossible de supprimer cette raison car elle est utilisée dans des justifications."
            ],  400
        );
         }
        return response()->json(['message' => 'Raison supprimée avec succès.'],200);

    }
}

//Impossible de supprimer cette raison car elle est utilisée dans des justifications.
