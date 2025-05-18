<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TypeResource;
use App\Models\Type;
use App\Traits\ApiTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TypeController extends Controller {
    use ApiTrait;

    public function index(Request $request): JsonResponse {
        try {
            $types = Type::
                orderByDesc('created_at')
                ->paginate(10);

            $groupedTypes = collect($types->items())
                ->groupBy('type')
                ->mapWithKeys(fn($items, $key) => [$key => TypeResource::collection($items)]);

            return $this->successResponse([
                'types'   => $groupedTypes,
                'pagination' => [
                    'total'         => $types->total(),
                    'per_page'      => $types->perPage(),
                    'current_page'  => $types->currentPage(),
                    'last_page'     => $types->lastPage(),
                ],
            ], 'Types retrieved successfully.', 200);

        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve Types.', 500, $e->getMessage());
        }
    }
}

