<?php

namespace App\Repositories;

use App\Models\Subject;

class SubjectRepository extends BaseRepository
{

    public $model;

    public function __construct(Subject $model)
    {
        $this->model = $model;
    }

    public function formatParams(array $params): array
    {
        return [
            'descricao' => $this->getAttribute($params, 'descricao'),
        ];
    }

    /**
     * @param string $sortBy
     * @param string $pluck
     * @return array
     */
    public function list($sortBy = 'name', $pluck = 'name'): array
    {
        return parent::list('descricao', 'descricao');
    }
}
