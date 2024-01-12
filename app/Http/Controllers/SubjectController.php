<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubjectResource;
use App\Services\SubjectService;

class SubjectController extends BaseController
{
    /**
     * @var SubjectService
     */
    protected $service;

    /**
     * @var string
     */
    protected string $resource = SubjectResource::class;

    public function __construct(SubjectService $service)
    {
        $this->service = $service;
    }
}
