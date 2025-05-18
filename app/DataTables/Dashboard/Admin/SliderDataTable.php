<?php

namespace App\DataTables\Dashboard\Admin;

use App\DataTables\Base\BaseDataTable;
use App\Models\Slider;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class SliderDataTable extends BaseDataTable {
    public function __construct(DataTableRequest $request)
    {
        parent::__construct(new Slider);
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (Slider $slider) {
                return view('dashboard.admin.sliders.btn.actions', compact('slider'));
            })
            ->editColumn('created_at', function (Slider $slider) {
                return $this->formatBadge($this->formatDate($slider->created_at));
            })
            ->editColumn('updated_at', function (Slider $slider) {
                return $this->formatBadge($this->formatDate($slider->updated_at));
            })
            ->editColumn('slider', function (Slider $slider) {
                return '<img src="' . $slider->getMediaUrl('slider') . '" class="img-fluid" alt="' . $slider->name . '"/>';
            })
            ->rawColumns(['action', 'created_at', 'updated_at', 'slider']);
    }

    public function query(): QueryBuilder
    {
        return Slider::with('media')->latest();
    }

    public function getColumns(): array
    {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false],
            ['name' => 'name', 'data' => 'name', 'title' => trans('dashboard/admin.name')],
            ['name' => 'slider', 'data' => 'slider', 'title' => 'الصوره', 'orderable' => false, 'searchable' => false],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => trans('dashboard/general.created_at'), 'orderable' => false, 'searchable' => false],
            ['name' => 'updated_at', 'data' => 'updated_at', 'title' => trans('dashboard/general.updated_at'), 'orderable' => false, 'searchable' => false],
            ['name' => 'action', 'data' => 'action', 'title' => trans('dashboard/general.actions'), 'orderable' => false, 'searchable' => false],
        ];
    }
}
