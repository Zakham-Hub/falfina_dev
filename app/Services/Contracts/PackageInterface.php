<?php

namespace App\Services\Contracts;

use App\DataTables\Dashboard\Admin\PackageDataTable;
use Illuminate\Http\Request;
use App\Models\Package;

interface PackageInterface
{
    public function index(PackageDataTable $packageDataTable);
    public function create();
    public function store(Request $request);
    public function edit(Package $package);
    public function update(Request $request, Package $package);
    public function destroy(Package $package);
}
