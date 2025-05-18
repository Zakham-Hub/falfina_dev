<?php
namespace App\Services\Contracts;

use App\DataTables\Dashboard\Admin\BranchDataTable;
use Illuminate\Http\Request;
use App\Models\Branch;
interface BranchInterface {
    public function index(BranchDataTable $branchDataTable);
    public function create();
    public function store(Request $request);
    public function edit($id);
    public function update(Request $request, $id);
    public function destroy(Branch $branch);
}
