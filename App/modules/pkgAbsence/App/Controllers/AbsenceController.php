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
use Illuminate\Support\Facades\Log;

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

    // Méthode pour ajout multiple d'absences (format frontend Vue) - CORRIGÉE
    public function storeMultiple(Request $request)
    {
        $request->validate([
            'absences' => 'required|array|min:1|max:100',
            'absences.*.apprenant_id' => 'required|exists:apprenants,id',
            'absences.*.seance_id' => 'required|exists:seances,id',
            'absences.*.user_id' => 'nullable|exists:users,id',
            'absences.*.justifie' => 'nullable|boolean',
            'absences.*.est_sanctionnée' => 'nullable|boolean',
        ], [
            'absences.required' => 'Au moins une absence doit être fournie.',
            'absences.max' => 'Vous ne pouvez pas créer plus de 100 absences à la fois.',
            'absences.*.apprenant_id.required' => 'L\'ID de l\'apprenant est requis.',
            'absences.*.apprenant_id.exists' => 'L\'apprenant sélectionné n\'existe pas.',
            'absences.*.seance_id.required' => 'L\'ID de la séance est requis.',
            'absences.*.seance_id.exists' => 'La séance sélectionnée n\'existe pas.',
        ]);

        try {
            // Préparer les données avec user_id par défaut
            $dataList = [];
            foreach ($request->absences as $absence) {
                $dataList[] = [
                    'user_id' => $absence['user_id'] ?? Auth::id(),
                    'apprenant_id' => $absence['apprenant_id'],
                    'seance_id' => $absence['seance_id'],
                    'justifie' => $absence['justifie'] ?? false,
                    'est_sanctionnée' => $absence['est_sanctionnée'] ?? false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            $result = $this->service->bulkCreateAbsences($dataList);

            // Gérer le résultat selon le type retourné par le service
            if (is_array($result) && isset($result['summary'])) {
                // Si le service retourne un array détaillé (version améliorée)
                $summary = $result['summary'];
                $messages = [];

                if ($summary['created_count'] > 0) {
                    $messages[] = "{$summary['created_count']} absence(s) créée(s) avec succès.";
                }

                if ($summary['skipped_count'] > 0) {
                    $messages[] = "{$summary['skipped_count']} absence(s) ignorée(s) (déjà existante(s)).";
                }

                if ($summary['error_count'] > 0) {
                    $messages[] = "{$summary['error_count']} erreur(s) rencontrée(s).";
                }

                $successMessage = implode(' ', $messages);
            } else {
                // Si le service retourne un booléen (version simple)
                $count = count($dataList);
                $successMessage = $result ? 
                    "{$count} absence(s) créée(s) avec succès." : 
                    "Erreur lors de la création des absences.";
            }

            return redirect()->route('Absences.index')->with('success', $successMessage);

        } catch (\Exception $e) {
            Log::error('Erreur dans storeMultiple: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withErrors(['error' => 'Erreur lors de la création des absences: ' . $e->getMessage()])
                ->withInput();
        }
    }

    // Méthode existante pour ajout multiple d'absences
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
                'created_at' => now(),
                'updated_at' => now(),
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
