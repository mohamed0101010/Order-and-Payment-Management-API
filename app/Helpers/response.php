<?php

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

if (!function_exists('api_response')) {
    function api_response(mixed $data = [], int $status = 200, string $message = '', ?int $actionCode = null): JsonResponse
    {
        $payload = [
            'data' => $data,
            'message' => $message,
        ];

        if (!is_null($actionCode)) {
            $payload['actionCode'] = $actionCode;
        }

        if (isset($data->resource) && $data->resource instanceof LengthAwarePaginator) {
            $payload['pagination'] = [
                'totalRecords' => $data->total(),
                'hasMoreData' => $data->hasMorePages()
            ];
        }

        return response()->json($payload, $status);
    }
}
