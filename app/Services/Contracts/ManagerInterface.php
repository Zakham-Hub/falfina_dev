<?php

namespace App\Services\Contracts;

use App\DataTables\Dashboard\Admin\ManagerDataTable;
use Illuminate\Http\Request;
use App\Models\Manager;

interface ManagerInterface
{
    public function index(ManagerDataTable $managerDataTable);
    public function create();
    public function store(Request $request);
    public function edit(Manager $manager);
    public function update(Request $request, Manager $manager);
    public function destroy(Manager $manager);
}
