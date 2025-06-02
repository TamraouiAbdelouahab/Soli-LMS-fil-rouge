<?php

namespace Modules\PkgApprenant\App\Services;
use Modules\PkgApprenant\App\Models\Apprenant;
class apprenantService
{
    public function Allgroups()
    {
        $apprenants = Apprenant::all();
        return $apprenants;
    }
}