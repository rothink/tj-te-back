<?php

namespace App\Services;

use App\Interfaces\RepositoryInterface;
use App\Interfaces\ServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class BaseService implements ServiceInterface
{
    /**
     *
     * @var RepositoryInterface
     */
    protected $repository;


    /**
     * @param RepositoryInterface $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    function getRepository(): RepositoryInterface
    {
        return $this->repository;
    }

    /**
     * @param string|int $id
     */
    public function delete(string|int $id): void
    {
        $this->repository->delete($id);
    }

    /**
     * @param Request $request
     * @return Model
     */
    public function save(Request $request): Model
    {
        return $this->repository->save($request->all());
    }

    /**
     * @param string|int $id
     * @return Model|null
     */
    public function find(string|int $id): ?Model
    {
        return $this->repository->find($id);
    }

    /**
     * @param Request $request
     * @param string|int $id
     * @return Model
     */
    public function update(Request $request, string|int $id): Model
    {
        $request['id'] = $id;
        $this->entity = $this->getRepository()->find($id);

        if (null === $this->entity) {
            throw new \Exception('Objeto não encontrado');
        }

        $this->repository->update($this->entity, $request->all());

        return $this->find($id);
    }

    public function getAll($params, $with = [])
    {
        return $this->getRepository()->getAll($params, $with);
    }

    /**
     * Pre Requisite default
     */
    public function preRequisite($id = null)
    {

    }
}
