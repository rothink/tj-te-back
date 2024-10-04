<?php

namespace App\Http\Controllers;

use App\Interfaces\ControllerInterface;
use App\Interfaces\ServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends Controller implements ControllerInterface
{

    /**
     *
     * @var ServiceInterface
     */
    protected $service;

    protected string $resource;

    /**
     * index function
     *
     * @param Request $request
     * @param [type] ...$params
     * @return JsonResponse
     */
    public function index(Request $request, ...$params): JsonResponse
    {
        $items = $this->service->getAll(array_merge($params, $request->all()));
        return isset($this->resource) ? $this->ok($this->resource::collection($items)) : $this->ok($items);
    }


    /**
     * Undocumented function
     *
     * @param string|integer $id
     * @return JsonResponse
     */
    public function show(string|int $id): JsonResponse
    {
        try {
            $item = $this->find($id);
            return isset($this->resource) ? $this->ok(new $this->resource($item)) : $this->ok($item);
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            if (isset($this->createRequest)) {
                $createRequest = app($this->createRequest);
                $request->validate($createRequest->rules());
            }
            DB::beginTransaction();
            $response = $this->service->save($request);
            DB::commit();
            return $this->success($this->messageSuccessDefault, $response, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e);
        }
    }

    /**
     * @param Request $request
     * @param int|string $id
     * @return JsonResponse
     */
    public function update(Request $request, int|string $id): JsonResponse
    {
        try {
            if (isset($this->updateRequest)) {
                $requestValidateUpdate = app($this->updateRequest);
                $request->validate($requestValidateUpdate->rules());
            }
            DB::beginTransaction();
            $response = $this->service->update($request, $id);
            DB::commit();
            return $this->success($this->messageSuccessDefault, $response);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e);
        }
    }

    /**
     * @param Request $request
     * @param string|int $id
     * @return JsonResponse
     */
    public function destroy(Request $request, string|int $id): JsonResponse
    {
        try {
            $this->find($id);
            $this->service->delete($id);
            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * @param string|int $id
     * @return Model
     */
    protected function find(string|int $id): Model
    {
        $entity = $this->service->find($id);
        if (null === $entity) {
            throw new \Exception('Objeto não encontrado no database');
        }
        return $entity;
    }

    /**
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function preRequisite($id = null)
    {
        $preRequisite = $this->service->preRequisite($id);
        return $this->ok(compact('preRequisite'));
    }
}
