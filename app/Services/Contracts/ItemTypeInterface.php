<?php

namespace App\Services\Contracts;

use App\DataTables\Dashboard\Admin\ItemTypeDataTable;
use App\Dto\ItemTypeDto;

interface ItemTypeInterface
{
    public function index(ItemTypeDataTable $itemTypeDataTable);

    public function store(ItemTypeDto $itemTypeDto);

    public function update(ItemTypeDto $itemTypeDto, $id);

    public function find($id);

    public function destroy($id);
}
