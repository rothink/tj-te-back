<?php

namespace App\Interfaces;

use App\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface ServiceInterface
{
    /**
     *
     * @return RepositoryInterface
     */
    public function getRepository(): RepositoryInterface;

    /**
     * @param Request $request
     * @return Model
     */
    public function save(Request $request): Model;

    /**
     * @param int $id
     */
    public function delete(int $id): void;
}
