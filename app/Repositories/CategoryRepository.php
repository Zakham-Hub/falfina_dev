<?php

namespace  App\Repositories;

use App\Models\Category;
use App\Services\Contracts\CategoryInterface;
use Illuminate\Http\Request;
use App\DataTables\Dashboard\Admin\CategoryDataTable;

class CategoryRepository implements CategoryInterface
{
    public function index(CategoryDataTable $categoryDataTable)
    {
        return $categoryDataTable->render('dashboard.admin.categories.index', ['pageTitle' => 'التصنيفات']);
    }

    public function create() {
        $categories = Category::getCategoryOptions();
        return view('dashboard.admin.categories.create', [
            'pageTitle' => 'إضافة تصنيف',
            'categories' => $categories
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'status' => 'nullable|in:active,inactive',
            'parent_id' => 'nullable|exists:categories,id',
        ]);
        $category = Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'parent_id' => $request->parent_id,
            'status' => $request->status,
        ]);
        if ($request->hasFile('category'))
            $category->uploadMedia($request->file('category'), 'category', 'root');
        return redirect()->route('admin.categories.index')->with('success', 'تم حفظ بنجاح!');
    }

    public function edit(Category $category) {
        $category->load('media');
        $categories = Category::getCategoryOptions();
        return view('dashboard.admin.categories.edit', [
            'pageTitle' => 'تعديل تصنيف',
            'category' => $category,
            'categories' => $categories
        ]);
    }

    public function update(Request $request,Category $category) {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'status' => 'nullable|in:active,inactive',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
        ]);
        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'parent_id' => $request->parent_id,
            'status' => $request->status,
        ]);
        if ($request->hasFile('category'))
            $category->updateMedia($request->file('category'), 'category', 'root');
        return redirect()->route('admin.categories.index')->with('success', 'تم حفظ بنجاح!');
    }

    /*public function destroy(Category $category) {
        $category->deleteMedia('category');
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'تم الحذف بنجاح!');
    }*/

    public function destroy(Category $category) {
        $subCategories = Category::where('parent_id', $category->id)->get(['id', 'name']);
        if ($subCategories->isNotEmpty()) {
            $subCategoryNames = $subCategories->pluck('name')->implode(', ');
            return redirect()->route('admin.categories.index')->with('error', 'لا يمكن حذف هذا التصنيف لأنه يحتوي على تصنيفات فرعية: ' . $subCategoryNames);
        }
        $category->deleteMedia('category');
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'تم الحذف بنجاح!');
    }
}
