<?php

namespace App\Repositories;

use App\Models\Book;

class BookRepository extends BaseRepository
{

    public $model;

    public function __construct(Book $model)
    {
        $this->model = $model;
    }

    public function formatParams(array $params): array
    {

        $formatted = [
            'titulo' => $this->getAttribute($params, 'titulo'),
            'editora' => $this->getAttribute($params, 'editora'),
            'edicao' => (int)$this->getAttribute($params, 'edicao'),
            'anoPublicacao' => (int)$this->getAttribute($params, 'anoPublicacao'),
            'valor' => $this->getAttribute($params, 'valor'),
        ];

        return $formatted;
    }
}
