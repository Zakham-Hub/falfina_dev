<?php

namespace App\DataTables\Dashboard\Admin;

use App\DataTables\Base\BaseDataTable;
use App\Models\Item;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class ItemDataTable extends BaseDataTable
{
    public function __construct(DataTableRequest $request)
    {
        parent::__construct(new Item);
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (Item $item) {
                return view('dashboard.admin.items.btn.actions', compact('item'));
            })
            ->editColumn('created_at', function (Item $item) {
                return $this->formatBadge($this->formatDate($item->created_at));
            })
            ->editColumn('updated_at', function (Item $item) {
                return $this->formatBadge($this->formatDate($item->updated_at));
            })
            ->addColumn('image', function (Item $item) {
                $media = $item->getMediaUrls('dashboard', $item, null, 'media', 'item') ?? null;
                return $media && isset($media['original'])
                    ? '<img src="' . $media['original'] . '" width="50" height="50" alt="Item Image">'
                    : 'No Image';
            })
            ->rawColumns(['action', 'created_at', 'updated_at', 'image']);
    }

    public function query(): QueryBuilder {
        return Item::with(['itemType', 'media'])->latest();
    }

    public function getColumns(): array
    {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false],
            ['name' => 'name', 'data' => 'name', 'title' => trans('dashboard/admin.item.name')],
            ['name' => 'item_type', 'data' => 'item_type.name', 'title' => trans('dashboard/admin.item.item_type')],
            ['name' => 'image', 'data' => 'image', 'title' => trans('dashboard/admin.item.image'), 'orderable' => false, 'searchable' => false],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => trans('dashboard/general.created_at'), 'orderable' => false, 'searchable' => false],
            ['name' => 'updated_at', 'data' => 'updated_at', 'title' => trans('dashboard/general.updated_at'), 'orderable' => false, 'searchable' => false],
            ['name' => 'action', 'data' => 'action', 'title' => trans('dashboard/general.actions'), 'orderable' => false, 'searchable' => false],
        ];
    }
}
