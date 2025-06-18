<?php

namespace Modules\PkgSanction\App\Controllers;

use Modules\Core\App\Controllers\BaseController;
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
            ['Sanction ID', 'Apprenant Name', 'Groupe', 'Rule', 'Date Applied', 'Status']
        ];

        foreach ($sanctions as $sanction) {
            // Extract apprenant names & groupes (assuming apprenant relation exists on absence)
            $apprenants = $sanction->absences->map(function ($absence) {
                return $absence->apprenant->name ?? 'N/A';
            })->unique()->implode(', ');

            // Extract groupes names (assuming groupes is a collection on apprenant)
            $groupes = $sanction->absences->flatMap(function ($absence) {
                return $absence->apprenant->groupes->pluck('name');
            })->unique()->implode(', ');

            $data[] = [
                $sanction->id,
                $apprenants,
                $groupes,
                $sanction->regle->name ?? 'N/A',
                $sanction->created_at->format('Y-m-d'),
                $sanction->status ?? 'N/A',
            ];
        }

        $export = $this->exportService->exportData($data, 'sanctions.xlsx');

        return response()->download($export['path'], $export['filename'])->deleteFileAfterSend(true);
    }
}
