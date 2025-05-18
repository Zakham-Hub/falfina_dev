<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Traits\ApiTrait;
use App\Http\Resources\ItemResource;
class ItemController extends Controller {
    use ApiTrait;
    public function index(Request $request) {
        $itemTypeId = $request->query('item_type_id');
        $itemsQuery = Item::with('media', 'itemType');
        if ($itemTypeId)
            $itemsQuery->where('item_type_id', $itemTypeId);
        $items = $itemsQuery->paginate(10);
        return $this->successResponse(ItemResource::collection($items), 'Items fetched successfully');
    }
}
