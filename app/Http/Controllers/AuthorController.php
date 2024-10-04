<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAuthorFormRequest;
use App\Http\Requests\UpdateAuthorFormRequest;
use App\Http\Resources\AuthorResource;
use App\Services\AuthorService;

class AuthorController extends BaseController
{
    /**
     * @var AuthorService
     */
    protected $service;

    /**
     * @var string
     */
    protected string $resource = AuthorResource::class;

    /**
     * @var string
     */
    protected string $createRequest = CreateAuthorFormRequest::class;

    /**
     * @var string
     */
    protected string $updateRequest = UpdateAuthorFormRequest::class;

    public function __construct(AuthorService $service)
    {
        $this->service = $service;
    }
}
