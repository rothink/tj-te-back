<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Mensagem padrão do sistema SUCCESS
     * @var string
     */
    protected $messageSuccessDefault = 'Operação realizada com com sucesso';

    /**
     * Mensagem padrão do sistema ERROR
     * @var string
     */
    protected $messageErrorDefault = 'Ops';

    public function ok(
        $items = [],
        $status = Response::HTTP_OK
    ): JsonResponse
    {
        $data = [
            'type' => 'success',
            'status' => $status,
            'data' => $items,
            'show' => false
        ];

        return response()->json($data, $status);
    }

    /**
     * @param null $message
     * @param null $items
     * @param int $status
     * @return JsonResponse
     */
    public function error(
        $message = null,
        $items = null,
        int $status = Response::HTTP_UNPROCESSABLE_ENTITY,
        \Exception|null $exception = null
    ): JsonResponse
    {
        if (is_null($message)) {
            $message = $this->messageErrorDefault;
        }

        if ($message instanceof \Exception) {
            $message = $message->getMessage();
        }

        $data = ['status' => 'error', 'message' => $message];

        if ($exception && env('APP_ENV') === 'local') {
            array_push($data, ['exception' => $exception->getTrace()]);
        }

        if (is_array($items)) {
            foreach ($items as $key => $item) {
                $data['errors'][$key] = $item;
            }
        }

        return response()->json($data, $status);
    }

    /**
     * @param $message
     * @param null $items
     * @param int $status
     * @return JsonResponse
     */
    public function success(
        $message = null,
        $items = null,
        int $status = Response::HTTP_OK
    ): JsonResponse
    {
        if (is_null($message)) {
            $message = $this->messageSuccessDefault;
        }

        $data = ['status' => $status, 'message' => $message, 'type' => 'success'];

        if ($items instanceof Arrayable) {
            $items = $items->toArray();
            foreach ($items as $key => $item) {
                $data['response'][$key] = $item;
            }
        }

        if ($items instanceof JsonResource) {
            $data['response'] = $items;
        }

        return response()->json(['data' => $data], $status);
    }
}
