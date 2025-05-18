<?php

namespace App\Services\Contracts;

use App\DataTables\Dashboard\Admin\ProductDataTable;
use Illuminate\Http\Request;
use App\Models\Product;

interface ProductInterface
{
    public function index(ProductDataTable $productDataTable);
    public function create();
    public function store(Request $request);
    public function edit(Product $product);
    public function update(Request $request, Product $product);
    public function destroy(Product $product);
}
