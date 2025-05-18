<?php

namespace App\Services\Services;

use App\DataTables\Dashboard\Admin\CategoryDataTable;
use App\Dto\CategoryDto;
use App\Repositories\CategoryRepository;
use App\Services\Contracts\CategoryInterface;

class CategoryService implements CategoryInterface
{
    protected CategoryRepository $categoryRepository;

    public function __construct()
    {
        $this->categoryRepository = new CategoryRepository;
    }

    public function index(CategoryDataTable $categoryDataTable)
    {
        return $this->categoryRepository->index($categoryDataTable);
    }

    public function store(CategoryDto $categoryDto)
    {
        return $this->categoryRepository->store($categoryDto);
    }

    public function update(CategoryDto $categoryDto, $id)
    {
        return $this->categoryRepository->update($categoryDto, $id);
    }

    public function find($id)
    {
        return $this->categoryRepository->find($id);
    }

    public function destroy($id)
    {
        return $this->categoryRepository->destroy($id);
    }
}
