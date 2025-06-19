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
    public function update($id,$data)
    {
        $data['code'] = strtoupper($data['code']);
        $raison = $this->reasonRepository->update($id,$data);
        return $raison;
    }
    public function delete(int $id): mixed
    {
        $reason = $this->repository->find($id);
        if ($reason && $reason->justifications()->exists()) {
            return false;
        }
        return $this->repository->delete($id);
    }
}
