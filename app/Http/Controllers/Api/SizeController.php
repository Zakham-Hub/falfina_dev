<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SizeResource;
use App\Models\Size;
use App\Traits\ApiTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    use ApiTrait;

    public function index(Request $request): JsonResponse
    {
        try {
            $sizes = Size::orderByDesc('created_at')
                ->paginate(10);

            $groupedSizes = collect($sizes->items())
                ->groupBy('type')
                ->mapWithKeys(fn($items, $key) => [$key => SizeResource::collection($items)]);

            return $this->successResponse([
                'sizes'   => $groupedSizes,
                'pagination' => [
                    'total'         => $sizes->total(),
                    'per_page'      => $sizes->perPage(),
                    'current_page'  => $sizes->currentPage(),
                    'last_page'     => $sizes->lastPage(),
                ],
            ], 'Sizes retrieved successfully.', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve Sizes.', 500, $e->getMessage());
        }
    }
}
