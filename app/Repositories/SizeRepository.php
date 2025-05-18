<?php

namespace App\Repositories;

use App\DataTables\Dashboard\Admin\SizeDataTable;
use App\Dto\SizeDto;
use App\Models\Size;

class SizeRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Size;
    }

    public function index(SizeDataTable $sizeDataTable)
    {
        return $sizeDataTable->render('dashboard.admin.sizes.index', ['pageTitle' => trans('dashboard/admin.size.sizes')]);
    }

    public function store(SizeDto $sizeDto)
    {
        return $this->model->create([
            'name' => $sizeDto->name,
            'gram' => $sizeDto->gram,
        ]);
    }

    public function update(SizeDto $sizeDto, $id)
    {
        $size = $this->model->findOrFail($id);
        $size->update([
            'name' => $sizeDto->name,
            'gram' => $sizeDto->gram,
        ]);

        return $size;
    }

    public function destroy($id)
    {
        $size = $this->find($id);

        return $size->delete();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }
}
