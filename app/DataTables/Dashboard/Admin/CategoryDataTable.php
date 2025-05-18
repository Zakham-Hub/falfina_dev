<?php

namespace App\DataTables\Dashboard\Admin;

use App\DataTables\Base\BaseDataTable;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class CategoryDataTable extends BaseDataTable
{
    public function __construct(DataTableRequest $request)
    {
        parent::__construct(new Category);
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (Category $category) {
                return view('dashboard.admin.categories.btn.actions', compact('category'));
            })
            ->editColumn('created_at', function (Category $category) {
                return $this->formatBadge($this->formatDate($category->created_at));
            })
            ->editColumn('updated_at', function (Category $category) {
                return $this->formatBadge($this->formatDate($category->updated_at));
            })
            ->editColumn('category', function (Category $category) {
                return '<img src="' . $category->getMediaUrl('category') . '" class="img-fluid" alt="' . $category->name . '" style="max-width: 100px; max-height: 100px; object-fit: cover; border-radius: 5px;"/>';
            })
            ->editColumn('parent_id', function (Category $category) {
                if (is_null($category->parent_id)) 
                    return '<span class="badge bg-success">تصنيف رئيسي</span>';
                return 'تصنيف فرعي من: <span class="text-primary"><br>' . $category->parent->name . '</span>';
            })
            ->editColumn('status', function (Category $category) {
                return $category->status === 'active'
                    ? '<span class="text-dark"><i class="fa fa-check text-success"></i> ' . $category->status_text . '</span>'
                    : '<span class="text-danger"><i class="fa fa-times-circle text-danger"></i> ' . $category->status_text . '</span>';
            })
            ->rawColumns(['action', 'created_at', 'updated_at', 'category', 'parent_id', 'status']);
    }

    public function query(): QueryBuilder
    {
        return Category::with('parent')->latest();
    }

    public function getColumns(): array
    {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false],
            ['name' => 'name', 'data' => 'name', 'title' => trans('dashboard/admin.category.name')],
            ['name' => 'category', 'data' => 'category', 'title' => 'الصوره', 'orderable' => false, 'searchable' => false],
            ['name' => 'parent_id', 'data' => 'parent_id', 'title' => 'التصنيف', 'orderable' => false, 'searchable' => false],
            ['name' => 'status', 'data' => 'status', 'title' => 'الحاله', 'orderable' => false, 'searchable' => false],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => trans('dashboard/general.created_at'), 'orderable' => false, 'searchable' => false],
            ['name' => 'updated_at', 'data' => 'updated_at', 'title' => trans('dashboard/general.updated_at'), 'orderable' => false, 'searchable' => false],
            ['name' => 'action', 'data' => 'action', 'title' => trans('dashboard/general.actions'), 'orderable' => false, 'searchable' => false],
        ];
    }
}
