<?php

namespace Modules\PkgJustificatif\App\Repositories;
use Modules\PkgJustificatif\App\Models\Justificatif;
use Modules\PkgApprenant\App\Models\Apprenant;
use Modules\PkgJustificatif\App\Models\Raison;


class raisonRepository extends BaseRepository
{
    public function __construct(Raison $raison)
    {
        parent::__construct($raison);
    }
    public function Allreason(){
        $reasons = Raison::all();
        return $reasons;
    }

}
