<?php

namespace Modules\PkgJustificatif\App\Services;
use Modules\PkgJustificatif\App\Repositories\justificatifRepository;

class justificatifService extends BaseService
{
    // protected $justificationRepository;

    public function __construct(protected JustificatifRepository $justificationRepository)
    {
        // $this->justificationRepository = $justificationRepository;
        parent::__construct($justificationRepository);
    }

    public function Alljustifications()
    {
        $allJustifications = $this->justificationRepository->Alljustifications();
        return $allJustifications;
    }
    public function ApprenantswithJustifications(){
        $apprenants = $this->justificationRepository->ApprenantswithJustifications();
        return $apprenants;
    }
    public function countapprenantwithjustification(){
        $count = $this->justificationRepository->countapprenantwithjustification();
        return $count;
    }
    
}
