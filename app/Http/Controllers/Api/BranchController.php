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
                ->with([
                    'dailySchedules.shifts',
                    'exceptionalHolidays',
                    'specialOccasions',
                ])
                ->orderByDesc('created_at')
                ->get();

            return $this->successResponse([
                'branches' => BranchResource::collection($branches),
                'count' => $branches->count(),
            ], 'Branches retrieved successfully.', 200);

        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve Branches.', 500, $e->getMessage());
        }
    }
}
