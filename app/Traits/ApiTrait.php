<?php

namespace App\Traits;

trait ApiTrait {
    protected function successResponse($data = null, string $message = 'Success', int $statusCode = 200, $resource = null) {
        if ($data instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator) {
            return response()->json([
                'status' => 'success',
                'message' => $message,
                'data' => $resource ? $resource::collection($data) : $data->items(),
                'pagination' => [
                    'total' => $data->total(),
                    'per_page' => $data->perPage(),
                    'current_page' => $data->currentPage(),
                    'last_page' => $data->lastPage(),
                    'next_page_url' => $data->nextPageUrl(),
                    'prev_page_url' => $data->previousPageUrl(),
                ],
            ], $statusCode);
        }

        if ($resource) {
            $data = $resource::collection($data);
        }

        $response = [
            'status' => 'success',
            'message' => $message,
        ];
        if (!is_null($data)) {
            $response['data'] = $data;
        }
        return response()->json($response, $statusCode);
    }

    protected function errorResponse(string $message = 'Error', int $statusCode = 400, $errors = null)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
        ], $statusCode);
    }

    protected function notFoundResponse(string $message = 'Resource not found')
    {
        return $this->errorResponse($message, 404);
    }

    protected function validationErrorResponse($errors, string $message = 'Validation failed')
    {
        return $this->errorResponse($message, 422, $errors);
    }
}
