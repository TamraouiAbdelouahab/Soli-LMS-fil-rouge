<?php

namespace Modules\PkgApprenant\App\Services;
use Modules\PkgApprenant\App\Models\Groupe;
class groupeService
{
    public function Allgroups()
    {
        $groups = Groupe::with("apprenants")->get();
        return $groups;
    }
}