<?php

namespace Modules\PkgJustificatif\App\Repositories;
use Modules\PkgJustificatif\App\Models\Justificatif;
use Modules\PkgApprenant\App\Models\Apprenant;


class justificatifRepository
{

    public function Alljustifications(){
        $justifications = Justificatif::with(['raison','apprenant.groupes'])->get();
        return $justifications;
    }
    public function ApprenantswithJustifications(){
        $topApprenants = Apprenant::select('id','nom','prenom')
                        ->withCount('justificatifs')
                        ->orderByDesc('justificatifs_count')
                        ->take(5)
                        ->get();
        return $topApprenants;
    }
    public function countapprenantwithjustification(){
        $count = Justificatif::distinct('apprenant_id')->count('apprenant_id');
        return $count;
    }
}
