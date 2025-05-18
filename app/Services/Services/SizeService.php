<?php

namespace App\Services\Services;

use App\DataTables\Dashboard\Admin\SizeDataTable;
use App\Dto\SizeDto;
use App\Repositories\SizeRepository;
use App\Services\Contracts\SizeInterface;

class SizeService implements SizeInterface
{
    protected SizeRepository $sizeRepository;

    public function __construct()
    {
        $this->sizeRepository = new SizeRepository;
    }

    public function index(SizeDataTable $sizeDataTable)
    {
        return $this->sizeRepository->index($sizeDataTable);
    }

    public function store(SizeDto $sizeDto)
    {
        return $this->sizeRepository->store($sizeDto);
    }

    public function update(SizeDto $sizeDto, $id)
    {
        return $this->sizeRepository->update($sizeDto, $id);
    }

    public function find($id)
    {
        return $this->sizeRepository->find($id);
    }

    public function destroy($id)
    {
        return $this->sizeRepository->destroy($id);
    }
}
