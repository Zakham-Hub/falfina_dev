<?php

namespace App\Services\Contracts;

use App\DataTables\Dashboard\Admin\AdminDataTable;
use App\Dto\AdminDto;

interface AdminInterface
{
    public function index(AdminDataTable $adminDataTable);

    public function store(AdminDto $adminDto);

    public function update(AdminDto $adminDto, $id);

    public function find($id);

    public function destroy($id);
}
