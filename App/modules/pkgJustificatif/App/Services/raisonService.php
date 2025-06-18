<?php

namespace Modules\PkgJustificatif\App\Services;

use Faker\Provider\Base;
use Modules\PkgJustificatif\App\Repositories\raisonRepository;
class raisonService extends BaseService
{
    // protected $reasonRepository;

    public function __construct(protected raisonRepository $reasonRepository)
    {
        // $this->reasonRepository = $reasonRepository;
        parent::__construct($reasonRepository);
    }

    public function Allreason()
    {
        $reasons = $this->reasonRepository->Allreason();
        return $reasons;
    }

    public function create($data)
    {
        $data['code'] = strtoupper($data['code']);
        $raison = $this->reasonRepository->create($data);
        return $raison;
    }
}
