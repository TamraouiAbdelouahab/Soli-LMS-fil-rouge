<?php 

namespace Modules\PkgJustificatif\App\Controllers;

use Inertia\Inertia;
use Modules\Core\App\Controllers\BaseController;

class DashboardController extends  BaseController
{
    public function index()
    {
        return Inertia::render('PkgJustificatif::Dashboard', [
            'sanctionsAbsenceCount' => 10
        ]);
    }
}


