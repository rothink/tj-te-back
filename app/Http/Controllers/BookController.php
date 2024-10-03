<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBookFormRequest;
use App\Http\Resources\BookResource;
use App\Services\BookService;

class BookController extends BaseController
{
    /**
     * @var BookService
     */
    protected $service;

    /**
     * @var string
     */
    protected string $resource = BookResource::class;

    /**
     * @var string
     */
    protected string $createRequest = CreateBookFormRequest::class;

    /**
     * @var string
     */
    protected string $updateRequest = CreateBookFormRequest::class;

    public function __construct(BookService $service)
    {
        $this->service = $service;
    }
}
