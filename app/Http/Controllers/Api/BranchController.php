<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BranchResource;
use App\Models\Branch;
use App\Traits\ApiTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    use ApiTrait;

    public function index(Request $request): JsonResponse
    {
        try {

            $branches = Branch::active()
                ->orderByDesc('created_at')
                ->paginate(10);

            // $groupedBranches = collect($branches->items())
            //     ->groupBy('type')
            //     ->mapWithKeys(fn($items, $key) => [$key => BranchResource::collection($items)]);
            $groupedBranches = collect($branches->items())
                ->groupBy(fn($branch) => $branch->type ?: 'data') // Default to 'unknown' for empty or null types
                ->mapWithKeys(fn($items, $key) => [$key => BranchResource::collection($items)]);

            return $this->successResponse([
                'branches'   => $groupedBranches,
                'pagination' => [
                    'total'         => $branches->total(),
                    'per_page'      => $branches->perPage(),
                    'current_page'  => $branches->currentPage(),
                    'last_page'     => $branches->lastPage(),
                ],
            ], 'Branches retrieved successfully.', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve Branches.', 500, $e->getMessage());
        }
    }
}
