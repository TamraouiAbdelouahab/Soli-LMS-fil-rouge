<?php

namespace Modules\PkgSanction\App\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Core\App\Controllers\BaseController;
use Modules\PkgApprenant\App\Services\groupeService;
use Modules\PkgSanction\App\Enum\SanctionType;
use Modules\PkgSanction\App\Services\SanctionCalculeeService;
use Modules\PkgSanction\App\Services\SanctionService;
use Illuminate\Support\Facades\Auth;

class SanctionController extends BaseController
{
    protected $sanctionService;
    protected $sanctionCalculeeService;
    protected $groupeService;

    public function __construct(SanctionService $sanctionService, SanctionCalculeeService $sanctionCalculeeService, groupeService $groupeService)
    {
        $this->sanctionService = $sanctionService;
        $this->sanctionCalculeeService = $sanctionCalculeeService;
        $this->groupeService = $groupeService;
    }

    public function index(Request $request)
    {
        return Inertia::render('PkgSanction::SanctionTracking', [
            'sanctionsApplied' => $this->sanctionService->getSanctionsApplied($request),
            'sanctionsAppliedCount' => $this->sanctionService->sanctionAbsenceCount(),
            'sanctionsCalculees' => $this->sanctionCalculeeService->getSanctionsCalculees($request),
            'sanctionsCalculeesCount' => $this->sanctionCalculeeService->sanctionAbsenceCalculeeCount(),
            'filters' => $request->only(['status', 'groupe_id', 'sanction_type', 'search']),
            'groupes' => $this->groupeService->getAllGroups(),
            'sanctionTypes' => array_map(fn($case) => [
                'value' => $case->value,
                'label' => $case->value
            ], SanctionType::cases()),
        ]);
    }

    public function calculateSanctions()
    {
        $this->sanctionCalculeeService->calculateSanctions();
        return redirect()->back()->with('success', 'Sanctions calculated successfully.');
    }

    public function applicationSanction($id)
    {
        $this->sanctionCalculeeService->applicationSanction($id);
        return redirect()->back()->with('success', 'Sanctions applied successfully.');
    }

    public function destroyCalculatedSanction($id)
    {
        $this->sanctionCalculeeService->deleteSanctionCalculee($id);
        return redirect()->back()->with('success', 'Sanction supprimé avec succès.');
    }

    public function destroyAppliedSanction($id)
    {
        $this->sanctionService->deleteSanction($id);
        return redirect()->back()->with('success', 'Sanction supprimé avec succès.');
    }

    public function learnerIndex()
    {
        $user = Auth::user();
        $apprenant = $user->apprenant;

        if (!$apprenant) {
            abort(404, 'Apprenant profile not found.');
        }

        return Inertia::render('PkgSanction::LearnerSanctions', [
            'sanctions' => $this->sanctionService->getLearnerSanctions($apprenant->id),
        ]);
    }
}
