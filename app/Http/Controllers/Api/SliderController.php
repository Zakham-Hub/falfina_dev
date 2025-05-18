<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SliderResource;
use App\Models\Slider;
use App\Traits\ApiTrait;
use Illuminate\Http\JsonResponse;

class SliderController extends Controller
{
    use ApiTrait;
    public function index(): JsonResponse
    {
        try {
            $sliders = Slider::with(['media'])->orderBy('created_at', 'DESC')->paginate(5);
            return $this->successResponse($sliders, 'Sliders retrieved successfully.', 200, SliderResource::class);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve sliders.', 500, $e->getMessage());
        }
    }
}
