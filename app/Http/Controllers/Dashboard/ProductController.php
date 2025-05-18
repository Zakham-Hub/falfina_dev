<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\Dashboard\Admin\ProductDataTable;
use App\Http\Controllers\Controller;
use App\Services\Contracts\ProductInterface;
use App\Models\Product;
use Illuminate\Http\Request;
class ProductController extends Controller
{
    public function __construct(protected ProductDataTable $productDataTable, protected ProductInterface $productInterface)
    {
        $this->productInterface = $productInterface;
        $this->productDataTable = $productDataTable;
    }

    public function index(ProductDataTable $productDataTable)
    {
        return $this->productInterface->index($this->productDataTable);
    }

    public function create() {
        return $this->productInterface->create();
    }

    public function store(Request $request)
    {
        return $this->productInterface->store($request);
    }

    public function edit(Product $product)
    {
        return $this->productInterface->edit($product);
    }

    public function update(Request $request, Product $product)
    {
        return $this->productInterface->update($request, $product);
    }

    public function destroy(Product $product)
    {
        return $this->productInterface->destroy($product);
    }
}
