<?php

namespace App\Services\Contracts;

use App\DataTables\Dashboard\Admin\CategoryDataTable;
use Illuminate\Http\Request;
use App\Models\Category;

interface CategoryInterface
{
    public function index(CategoryDataTable $categoryDataTable);
    public function create();
    public function store(Request $request);
    public function edit(Category $category);
    public function update(Request $request, Category $category);
    public function destroy(Category $category);
}
