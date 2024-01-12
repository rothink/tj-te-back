<?php

namespace App\Services;

use App\Repositories\SubjectRepository;

class SubjectService extends BaseService
{
    protected $repository;

    public function __construct(SubjectRepository $repository)
    {
        $this->repository = $repository;
    }
}
