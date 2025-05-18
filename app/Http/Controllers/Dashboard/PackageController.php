<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Dashboard\Admin\PackageDataTable;
use App\Services\Contracts\PackageInterface;
use App\Models\Package;

class PackageController extends Controller
{
    public function __construct(protected PackageDataTable $packageDataTable, protected PackageInterface $packageInterface)
    {
        $this->packageInterface = $packageInterface;
        $this->packageDataTable = $packageDataTable;
    }

    public function index(PackageDataTable $packageDataTable)
    {
        return $this->packageInterface->index($this->packageDataTable);
    }

    public function create()
    {
        return $this->packageInterface->create();
    }

    public function store(Request $request)
    {
        return $this->packageInterface->store($request);
    }

    public function edit(Package $package)
    {
        return $this->packageInterface->edit($package);
    }

    public function update(Request $request, Package $package)
    {
        return $this->packageInterface->update($request, $package);
    }

    public function destroy(Package $package)
    {
        return $this->packageInterface->destroy($package);
    }
}
