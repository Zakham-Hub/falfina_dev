<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Dashboard\Admin\ManagerDataTable;
use App\Services\Contracts\ManagerInterface;
use App\Models\Manager;

class ManagerController extends Controller
{
    public function __construct(protected ManagerDataTable $managerDataTable, protected ManagerInterface $managerInterface)
    {
        $this->managerInterface = $managerInterface;
        $this->managerDataTable = $managerDataTable;
    }

    public function index(ManagerDataTable $managerDataTable)
    {
        return $this->managerInterface->index($this->managerDataTable);
    }

    public function create()
    {
        return $this->managerInterface->create();
    }

    public function store(Request $request)
    {
        return $this->managerInterface->store($request);
    }

    public function edit(Manager $manager)
    {
        return $this->managerInterface->edit($manager);
    }

    public function update(Request $request, Manager $manager)
    {
        return $this->managerInterface->update($request, $manager);
    }

    public function destroy(Manager $manager)
    {
        return $this->managerInterface->destroy($manager);
    }
}
