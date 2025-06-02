<?php

namespace Modules\PkgJustificatif\App\Services;
use Modules\PkgJustificatif\App\Repositories\raisonRepository;
class raisonService
{
    protected $reasonRepository;

    public function __construct(raisonRepository $reasonRepository)
    {
        $this->reasonRepository = $reasonRepository;
    }

    public function Allreason()
    {
        $reasons = $this->reasonRepository->Allreason();
        return $reasons;
    }
}
