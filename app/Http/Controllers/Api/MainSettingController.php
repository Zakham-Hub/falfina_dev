<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\MainSettingResource;
use App\Models\Setting;
use App\Traits\ApiTrait;
use Illuminate\Http\JsonResponse;
class MainSettingController extends Controller {
    use ApiTrait;
    public function index(): JsonResponse {
        try {
            $setting = Setting::with(['media'])->orderBy('created_at', 'DESC')->first();
            if (!$setting) {
                return $this->notFoundResponse('No settings found.');
            }
            return $this->successResponse(new MainSettingResource($setting), 'Settings retrieved successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve settings.', 500, $e->getMessage());
        }
    }
}
