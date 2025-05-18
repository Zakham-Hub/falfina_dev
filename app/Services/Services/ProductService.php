<?php

namespace App\Services\Services;

use App\DataTables\Dashboard\Admin\ProductDataTable;
use App\Dto\ProductDto;
use App\Repositories\ProductRepository;
use App\Services\Contracts\ProductInterface;

class ProductService implements ProductInterface
{
    protected ProductRepository $productRepository;

    public function __construct()
    {
        $this->productRepository = new ProductRepository;
    }

    public function index(ProductDataTable $productDataTable)
    {
        return $this->productRepository->index($productDataTable);
    }

    public function store(ProductDto $productDto)
    {
        return $this->productRepository->store($productDto);
    }

    public function update(ProductDto $productDto, $id)
    {
        return $this->productRepository->update($productDto, $id);
    }

    public function find($id)
    {
        return $this->productRepository->find($id);
    }

    public function destroy($id)
    {
        return $this->productRepository->destroy($id);
    }
}
