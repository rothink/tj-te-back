<?php

namespace App\Http\Controllers;

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

    public function __construct(AuthorService $service)
    {
        $this->service = $service;
    }
}
