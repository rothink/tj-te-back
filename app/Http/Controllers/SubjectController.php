<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSubjectFormRequest;
use App\Http\Requests\UpdateSubjectFormRequest;
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

    /**
     * @var string
     */
    protected string $createRequest = CreateSubjectFormRequest::class;

    /**
     * @var string
     */
    protected string $updateRequest = UpdateSubjectFormRequest::class;

    public function __construct(SubjectService $service)
    {
        $this->service = $service;
    }
}
