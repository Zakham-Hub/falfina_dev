<?php

namespace App\Services\Contracts;

use App\DataTables\Dashboard\Admin\SizeDataTable;
use App\Dto\SizeDto;

interface SizeInterface
{
    public function index(SizeDataTable $sizeDataTable);

    public function store(SizeDto $sizeDto);

    public function update(SizeDto $sizeDto, $id);

    public function find($id);

    public function destroy($id);
}
