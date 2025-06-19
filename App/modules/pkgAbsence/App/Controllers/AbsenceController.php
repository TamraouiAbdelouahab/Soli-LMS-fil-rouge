<?php
namespace Modules\PkgAbsence\App\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\PkgAbsence\App\Services\AbsenceService;
use Modules\Core\App\Controllers\BaseController;

class AbsenceController extends BaseController
{
    protected $absenceService;

    public function __construct(AbsenceService $absenceService)
    {
        $this->absenceService = $absenceService;
    }

    public function index()
    {
        return Inertia::render('pkgAbsence::Absences/Index', [
            // 'absences' => $this->absenceService->getAbsences(),
        ]);
    }

    public function create()
    {
        return Inertia::render('pkgAbsence::Absences/Create', [
            // 'absences' => $this->absenceService->getAbsences(),
        ]);
    }
}   