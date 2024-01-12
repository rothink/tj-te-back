<?php

namespace App\Repositories;

use App\Models\Author;

class AuthorRepository extends BaseRepository
{

    public $model;

    public function __construct(Author $model)
    {
        $this->model = $model;
    }

    public function formatParams(array $params): array
    {
        return [
            'nome' => $this->getAttribute($params, 'nome'),
        ];
    }

    /**
     * @param string $sortBy
     * @param string $pluck
     * @return array
     */
    public function list($sortBy = 'name', $pluck = 'name'): array
    {
        return parent::list('nome', 'nome');
    }
}
