<?php

namespace App\Repositories;

use App\Interfaces\RepositoryInterface;
use App\Models\Book;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements RepositoryInterface
{

    /**
     * @return Book|Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param null $params
     * @param array|null $with
     * @param string $orderBy
     * @return mixed
     */
    public function getAll($params = null, ?array $with = [], string $orderBy = 'id'): mixed
    {
        return $this->getModel()->with($with)->simplePaginate(100)->withQueryString();
    }

    /**
     * Retorna em forma de lista para select
     * @return mixed
     */
    public function list($sortBy = 'name', $pluck = 'name'): array
    {
        return $this->getModel()->all()->sortBy($sortBy)->pluck($pluck, 'id')->all();
    }
//
    /**
     * @param array $params
     * @return Model
     */
    public function save(array $params): Model
    {
        return $this->getModel()->forceCreate($this->formatParams($params));
    }

    /**
     * @param int|string $id
     * @param array $with
     * @return Model|null
     */
    public function find(int|string $id, array $with = []) :Model|null
    {
        return $this->getModel()->with($with)->find($id);
    }

    /**
     * @param string|int $id
     */
    public function delete(string|int $id) :void
    {
        $entity = $this->find($id);
        $entity->delete();
    }

    /**
     * @param Model $entity
     * @param array $data
     * @return bool
     */
    public function update(Model $entity, array $data): bool
    {
        return $entity->forceFill($this->formatParams($data))->update();
    }
//
    /**
     * @param array $params
     * @param string $value
     * @param null $default
     * @return mixed|null
     */
    public function getAttribute(array $params, string $value, $default = null): mixed
    {
        return (isset($params[$value])) ? $params[$value] : $default;
    }
}
