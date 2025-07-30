<?php
namespace App\Services\Contracts;

use App\DataTables\Dashboard\Admin\BranchDataTable;
use App\Http\Requests\StoreBranchRequest;
use Illuminate\Http\Request;
use App\Models\Branch;
interface BranchInterface {
    public function index(BranchDataTable $branchDataTable);
    public function create();
    public function store(StoreBranchRequest $request);
    public function edit($id);
    public function update(StoreBranchRequest $request, $id);
    public function destroy(Branch $branch);
}
