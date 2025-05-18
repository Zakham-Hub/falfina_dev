<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExtraResource;
use App\Models\Extra;
use App\Traits\ApiTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class ExtraController extends Controller {
    use ApiTrait;
    public function index(Request $request): JsonResponse {
        try {
            $type = $request->input('type');
            $query = Extra::with(['media'])->orderBy('created_at', 'DESC');
            if (in_array($type, ['sauce', 'addon'])) {
                $extras = $query->where('type', $type)->paginate(5);
                return $this->successResponse($extras, 'Extras retrieved successfully.', 200, ExtraResource::class);
            }
            $extras = $query->paginate(10);
            $groupedExtras = collect($extras->items())
                ->groupBy('type')
                ->mapWithKeys(fn($items, $key) => [$key => ExtraResource::collection($items)])
                ->toArray();
            return $this->successResponse([
                ...$groupedExtras, 
                'pagination' => [
                    'total' => $extras->total(),
                    'per_page' => $extras->perPage(),
                    'current_page' => $extras->currentPage(),
                    'last_page' => $extras->lastPage(),
                ],
            ], 'Extras retrieved successfully.', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve Extras.', 500, $e->getMessage());
        }
    }
}
