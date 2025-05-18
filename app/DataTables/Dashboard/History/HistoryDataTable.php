<?php

namespace App\DataTables\Dashboard\History;

use App\DataTables\Base\BaseDataTable;
use App\Models\History;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class HistoryDataTable extends BaseDataTable
{
    public function __construct(DataTableRequest $request)
    {
        parent::__construct(new History);
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable
    {
        return (new EloquentDataTable($query))

            ->addColumn('model_name', function ($history) {
                return $history->model_name;
            })
            ->addColumn('related_name', function ($history) {
                return $history->related_name ?? '-';
            })
            ->addColumn('changed_column', function ($history) {
                return $history->changed_column;
            })
            ->addColumn('change_value_from', function ($history) {
                return $history->change_value_from ?? '-';
            })
            ->addColumn('change_value_to', function ($history) {
                return $history->change_value_to ?? '-';
            })
            ->addColumn('changed_by', function ($history) {
                if ($history->admin) {
                    return '<span class="badge bg-success">' . $history->admin->name . '</span>';
                } elseif ($history->manager) {
                    $managerName = $history->manager->name;
                    $branchName = $history->manager->branch->name ?? 'بدون فرع';

                    return '<span class="badge bg-primary d-block">'
                        . $managerName . '</span>'
                        . '<small class="text-muted text-center">الفرع: ' . $branchName . '</small>';
                } elseif ($history->user) {
                    return '<span class="badge bg-info">' . $history->user->name . '</span>';
                }
                return '<span class="text-muted">غير معروف</span>';
            })
            ->editColumn('created_at', function ($history) {
                return $history->created_at->format('Y-m-d h:i A');
            })
            ->rawColumns(['changed_by']);
    }

    public function query(): QueryBuilder
    {
        return History::with(['admin', 'manager', 'user', 'historyable'])->latest();
    }

    public function getColumns(): array
    {
        return [
            [
                'title' => 'النوع',
                'data' => 'model_name',
                'name' => 'historyable_type',
            ],
            [
                'title' => 'الاسم المرتبط',
                'data' => 'related_name',
                'name' => 'related_name',
                'orderable' => false,
                'searchable' => false,
            ],
            [
                'title' => 'العمود المعدل',
                'data' => 'changed_column',
                'name' => 'changed_column',
                'searchable' => true,
            ],
            [
                'title' => 'القيمة القديمة',
                'data' => 'change_value_from',
                'name' => 'change_value_from',
                'searchable' => true,
            ],
            [
                'title' => 'القيمة الجديدة',
                'data' => 'change_value_to',
                'name' => 'change_value_to',
                'searchable' => true,
            ],
            [
                'title' => 'تم التعديل بواسطة',
                'data' => 'changed_by',
                'name' => 'admin_id',
                'orderable' => false,
                'searchable' => false,
            ],
            [
                'title' => 'تاريخ التعديل',
                'data' => 'created_at',
                'name' => 'created_at',
            ],
        ];
    }
}
