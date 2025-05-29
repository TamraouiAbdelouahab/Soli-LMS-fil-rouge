<?php

namespace Modules\PkgSanction\App\Controllers;

use Inertia\Inertia;
use Modules\Core\App\Controllers\BaseController;
use Modules\PkgSanction\App\Requests\SanctionRulesRequest;
use Modules\PkgSanction\App\Services\SanctionRulesService;

class SanctionRulesController extends BaseController
{
    protected $sanctionRulesService;

    public function __construct(SanctionRulesService $sanctionRulesService)
    {
        $this->sanctionRulesService = $sanctionRulesService;
    }

    public function index()
    {
        return Inertia::render('PkgSanction::SanctionRules', [
            'sanctionRules' => $this->sanctionRulesService->getSanctionRules(),
            'rulesCount' => $this->sanctionRulesService->rulesCount(),
            'activeRulesCount' => $this->sanctionRulesService->activeRulesCount(),
            'lastModificationDate' => $this->sanctionRulesService->getLastModificationDate(),
            'learnersSanctionedCount' => $this->sanctionRulesService->learnersSanctionedCount(),
        ]);
    }

    public function store(SanctionRulesRequest $request)
    {
        try {
            $this->sanctionRulesService->createSanctionRule($request->validated());
            return redirect()->back()->with('success', 'Règle créée avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
