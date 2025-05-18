<?php

namespace App\DataTables\Dashboard\Admin;

use App\DataTables\Base\BaseDataTable;
use App\Models\{Setting,Extra};
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;
use Illuminate\Support\Facades\Cache;
class ExtraDataTable extends BaseDataTable
{
    public function __construct(DataTableRequest $request)
    {
        parent::__construct(new Extra);
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (Extra $extra) {
                return view('dashboard.admin.extras.btn.actions', compact('extra'));
            })
            ->editColumn('created_at', function (Extra $extra) {
                return $this->formatBadge($this->formatDate($extra->created_at));
            })
            ->editColumn('updated_at', function (Extra $extra) {
                return $this->formatBadge($this->formatDate($extra->updated_at));
            })
            ->editColumn('type', function (Extra $extra) {
                return ['addon' => 'إضافة', 'sauce' => 'صوص'][$extra->type] ?? 'غير معروف';
            })
            ->editColumn('extra', function (Extra $extra) {
            return '<img src="' . $extra->getMediaUrl('extra') . '" class="img-fluid" alt="' . $extra->name . '" style="max-width: 100px; max-height: 100px; object-fit: cover; border-radius: 5px;"/>';
            })
            ->editColumn('price', function (Extra $extra) {
                $settings = Cache::get('settings', new Setting());
                return $extra->price . ' ' . ($settings?->currency ?? 'ر.س');
            })
            ->rawColumns(['action', 'created_at', 'updated_at', 'type', 'extra']);
    }

    public function query(): QueryBuilder
    {
        return Extra::latest();
    }

    public function getColumns(): array
    {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false],
            ['name' => 'name', 'data' => 'name', 'title' => trans('dashboard/admin.name')],
            ['name' => 'extra', 'data' => 'extra', 'title' => 'الصوره', 'orderable' => false, 'searchable' => false],
            ['name' => 'type', 'data' => 'type', 'title' => 'النوع', 'orderable' => true, 'searchable' => true],
            ['name' => 'price', 'data' => 'price', 'title' => 'السعر', 'orderable' => true, 'searchable' => true],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => trans('dashboard/general.created_at'), 'orderable' => false, 'searchable' => false],
            ['name' => 'updated_at', 'data' => 'updated_at', 'title' => trans('dashboard/general.updated_at'), 'orderable' => false, 'searchable' => false],
            ['name' => 'action', 'data' => 'action', 'title' => trans('dashboard/general.actions'), 'orderable' => false, 'searchable' => false],
        ];
    }
}
