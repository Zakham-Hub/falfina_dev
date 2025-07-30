<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Dashboard\Admin\BranchDataTable;
use App\Http\Requests\StoreBranchRequest;
use App\Models\Branch;
use App\Services\Contracts\BranchInterface;
class BranchController extends Controller {
    public function __construct(protected BranchDataTable $branchDataTable, protected BranchInterface $branchInterface) {
        $this->branchInterface = $branchInterface;
        $this->branchDataTable = $branchDataTable;
    }

    public function index(BranchDataTable $branchDataTable) {
        return $this->branchInterface->index($this->branchDataTable);
    }

    public function create() {
        return $this->branchInterface->create();
    }

    public function store(StoreBranchRequest $request) {
        return $this->branchInterface->store($request);
    }

    public function edit($id)
    {
        return $this->branchInterface->edit($id);
    }

    public function update(StoreBranchRequest $request, $id)
    {
        return $this->branchInterface->update($request, $id);
    }

    public function destroy(Branch $branch)
    {
        return $this->branchInterface->destroy($branch);
    }
}
