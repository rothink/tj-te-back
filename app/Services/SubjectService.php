<?php

namespace App\Services;

use App\Repositories\SubjectRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SubjectService extends BaseService
{
    protected $repository;

    public function __construct(SubjectRepository $repository)
    {
        $this->repository = $repository;
    }

    public function save(Request $request): Model
    {
        if (strlen(($request->input('descricao'))) > 20) {
            throw new \Exception('Descrição não pode ser maior que 20 caracteres');
        }
        return parent::save($request);
    }

    public function delete(int|string $id): void
    {
        $author = $this->repository->find($id, ['books']);
        if (count($author->books) > 0) {
            throw new \Exception('Assunto possui livros relacionados');
        }
        parent::delete($id);
    }
}
