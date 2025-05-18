<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use App\Traits\ApiTrait;
use App\Models\Product;
class ProductController extends Controller {
    use ApiTrait;
    public function index(Request $request) {
        $products = Product::with(['categories', 'sizes', 'types', 'extras', 'media'])->paginate(20);
        return $this->successResponse($products, 'Products retrieved successfully', 200, ProductResource::class);
    }
}
