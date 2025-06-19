<?php

namespace Modules\PkgSanction\App\Controllers;

use Modules\Core\App\Controllers\BaseController;
use Modules\PkgSanction\App\Models\ReglesDeSanction;
use Modules\PkgSanction\App\Models\SanctionAbsence;
use Modules\PkgSanction\App\Services\ExportService;

class ExportController extends BaseController
{
    protected $exportService;

    public function __construct(ExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    public function exportSanctions()
    {
        $sanctions = SanctionAbsence::with('absences.apprenant.groupes', 'regle')
            ->orderBy('created_at', 'desc')
            ->get();

        // Prepare header row
        $data = [
            ['Sanction ID', 'Apprenant Name', 'Groupe', 'Rule', 'Date Debut', 'Date Fin', 'Status']
        ];

        foreach ($sanctions as $sanction) {
            // Extract apprenant names & groupes (assuming apprenant relation exists on absence)
            $apprenants = $sanction->absences->map(function ($absence) {
                return $absence->apprenant->prenom . ' '. $absence->apprenant->nom ?? 'N/A';
            })->unique()->implode(', ');

            $groupe = $sanction->absences->flatMap(function ($absence) {
                return $absence->apprenant->groupes->pluck('nom');
            })->unique()->implode(', ');

            $data[] = [
                $sanction->id,
                $apprenants,
                $groupe,
                $sanction->regle->titre ?? 'N/A',
                $sanction->date_debut,
                $sanction->date_fin,
                $sanction->status ?? 'N/A',
            ];
        }

        $export = $this->exportService->exportData($data, 'sanctions.csv');

        return response()->download($export['path'], $export['filename'])->deleteFileAfterSend(true);
    }

        public function exportRules()
    {
        $sanctions = ReglesDeSanction::all();
        
        // Prepare header row
        $data = [
            ['Regle ID', 'Titre', 'Description', 'Absences Max', 'Seuil de Notification', 'Duree Sanction', 'Est Actif', 'Sanction Type']
        ];

        foreach ($sanctions as $sanction) {
            // Extract apprenant names & groupes (assuming apprenant relation exists on absence)
            $apprenants = $sanction->absences->map(function ($absence) {
                return $absence->apprenant->prenom . ' '. $absence->apprenant->nom ?? 'N/A';
            })->unique()->implode(', ');

            $groupe = $sanction->absences->flatMap(function ($absence) {
                return $absence->apprenant->groupes->pluck('nom');
            })->unique()->implode(', ');

            $data[] = [
                $sanction->id,
                $apprenants,
                $groupe,
                $sanction->regle->titre ?? 'N/A',
                $sanction->date_debut,
                $sanction->date_fin,
                $sanction->status ?? 'N/A',
            ];
        }

        $export = $this->exportService->exportData($data, 'sanctions.csv');

        return response()->download($export['path'], $export['filename'])->deleteFileAfterSend(true);
    }
}
