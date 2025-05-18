<?php

namespace App\Services\Services;

use App\DataTables\Dashboard\Admin\ItemTypeDataTable;
use App\Dto\ItemTypeDto;
use App\Repositories\ItemTypeRepository;
use App\Services\Contracts\ItemTypeInterface;

class ItemTypeService implements ItemTypeInterface
{
    protected ItemTypeRepository $itemTypeRepository;

    public function __construct()
    {
        $this->itemTypeRepository = new ItemTypeRepository;
    }

    public function index(ItemTypeDataTable $itemTypeDataTable)
    {
        return $this->itemTypeRepository->index($itemTypeDataTable);
    }

    public function store(ItemTypeDto $itemTypeDto)
    {
        return $this->itemTypeRepository->store($itemTypeDto);
    }

    public function update(ItemTypeDto $itemTypeDto, $id)
    {
        return $this->itemTypeRepository->update($itemTypeDto, $id);
    }

    public function find($id)
    {
        return $this->itemTypeRepository->find($id);
    }

    public function destroy($id)
    {
        return $this->itemTypeRepository->destroy($id);
    }
}
