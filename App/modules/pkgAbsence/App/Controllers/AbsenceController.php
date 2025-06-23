<?php

namespace Modules\PkgAbsence\App\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\PkgAbsence\App\Services\GererAbsence;
use Modules\PkgApprenant\App\Models\Apprenant;
use Modules\PkgApprenant\App\Models\Groupe;
use App\Models\Seance;
use Illuminate\Support\Facades\Auth;

class AbsenceController extends Controller
{
    protected $service;

    public function __construct(GererAbsence $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return Inertia::render('pkgAbsence::Absence/Index', [
            'absences' => $this->service->listAbsences()->load(['apprenant.groupes', 'seance']),
            'apprenants' => Apprenant::with('groupes')->select('id', 'nom', 'prenom')->get(),
            'seances' => Seance::select('id', 'date_debut', 'date_fin')->get(),
            'groupes' => Groupe::select('id', 'nom')->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'apprenant_id' => 'required|exists:apprenants,id',
            'seance_id' => 'required|exists:seances,id',
        ]);

        $this->service->createAbsence($request->all());
        return redirect()->route('Absences.index')->with('success', 'Absence ajoutée');
    }

    // Nouvelle méthode pour ajout multiple d'absences
    public function bulkStore(Request $request)
    {
        $request->validate([
            'seance_id' => 'required|exists:seances,id',
            'apprenant_ids' => 'required|array',
            'apprenant_ids.*' => 'exists:apprenants,id',
            'justifie' => 'nullable|boolean',
            'est_sanctionnée' => 'nullable|boolean',
        ]);

        $dataList = [];
        foreach ($request->apprenant_ids as $apprenant_id) {
            $dataList[] = [
                'user_id' => Auth::id(),
                'apprenant_id' => $apprenant_id,
                'seance_id' => $request->seance_id,
                'justifie' => $request->justifie ?? false,
                'est_sanctionnée' => $request->est_sanctionnée ?? false,
            ];
        }

        $this->service->bulkCreateAbsences($dataList);

        return redirect()->route('Absences.index')->with('success', 'Absences ajoutées avec succès.');
    }

    public function edit($id)
    {
        return $this->service->getAbsence($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'apprenant_id' => 'required|exists:apprenants,id',
            'seance_id' => 'required|exists:seances,id',
        ]);

        $this->service->updateAbsence($id, $request->all());
        return redirect()->route('Absences.index')->with('success', 'Absence mise à jour');
    }

    public function destroy($id)
    {
        $this->service->deleteAbsence($id);
        return redirect()->route('Absences.index')->with('success', 'Absence supprimée');
    }
}
