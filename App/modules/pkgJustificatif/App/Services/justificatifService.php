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
        $count = $this->justificationRepository->Alljustifications();
        return $count;
    }

    public function ApprenantswithJustifications(){
        $apprenants = $this->justificationRepository->ApprenantswithJustifications();
        return $apprenants;
    }
}
