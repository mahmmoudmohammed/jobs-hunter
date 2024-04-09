<?php

namespace App\Http\Api\Traits;

use App\Exceptions\CustomValidationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

trait ApiDesignTrait
{
    /**
     * Throw validation exception.
     *
     * @param string $message
     *
     * @throws CustomValidationException
     */
    public function throwValidationException(string $message): void
    {
        throw CustomValidationException::make($message);
    }

    /**
     * Response with success.
     *
     * @return JsonResponse
     */
    public function success(): JsonResponse
    {
        return response()->json(['message' => __('common.success')], 200);
    }

    public function error($message, $status = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return response()->json(compact('message'), $status);
    }

    /**
     * Response with normal json array.
     *
     * @param int $code
     * @param null $message
     * @param null $data
     * @return JsonResponse
     */
    public function ApiResponse(int $code = 200, $message = null, $data = null): JsonResponse
    {
        $array = [
            'status' => $code,
            'message' => $message,
        ];

        if ($data)
            $array['message'] = $data;

        return response()->json($array, $code);
    }

    /**
     * Response with resource.
     *
     * @param mixed $resource
     * @param array|null $additional
     * @param integer $status
     * @return JsonResponse
     */
    public function responseResource(JsonResource $resource, array $additional = null, int $status = 200): JsonResponse
    {
        if ($additional) {
            $resource->additional($additional);
        }
        return $resource->response()
            ->setStatusCode($status);
    }


}
