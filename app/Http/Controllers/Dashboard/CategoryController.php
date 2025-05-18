<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Dashboard\Admin\CategoryDataTable;
use App\Services\Contracts\CategoryInterface;
use App\Models\Category;

class CategoryController extends Controller {
    public function __construct(protected CategoryDataTable $categoryDataTable, protected CategoryInterface $categoryInterface)
    {
        $this->categoryInterface = $categoryInterface;
        $this->categoryDataTable = $categoryDataTable;
    }

    public function index(CategoryDataTable $categoryDataTable)
    {
        return $this->categoryInterface->index($this->categoryDataTable);
    }

    public function create()
    {
        return $this->categoryInterface->create();
    }

    public function store(Request $request)
    {
        return $this->categoryInterface->store($request);
    }

    public function edit(Category $category)
    {
        return $this->categoryInterface->edit($category);
    }

    public function update(Request $request, Category $category)
    {
        return $this->categoryInterface->update($request, $category);
    }

    public function destroy(Category $category)
    {
        return $this->categoryInterface->destroy($category);
    }
}
