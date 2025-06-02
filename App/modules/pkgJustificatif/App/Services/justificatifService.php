<?php

namespace Modules\PkgJustificatif\App\Services;
use Modules\PkgJustificatif\App\Repositories\justificatifRepository;
class justificatifService
{
    protected $justificationRepository;

    public function __construct(JustificatifRepository $justificationRepository)
    {
        $this->justificationRepository = $justificationRepository;
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
