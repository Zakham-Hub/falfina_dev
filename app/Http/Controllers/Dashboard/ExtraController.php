<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Dashboard\Admin\ExtraDataTable;
use App\Services\Contracts\ExtraInterface;
use App\Models\Extra;

class ExtraController extends Controller
{
    public function __construct(protected ExtraDataTable $extraDataTable, protected ExtraInterface $extraInterface)
    {
        $this->extraInterface = $extraInterface;
        $this->extraDataTable = $extraDataTable;
    }

    public function index(ExtraDataTable $extraDataTable)
    {
        return $this->extraInterface->index($this->extraDataTable);
    }

    public function create()
    {
        return $this->extraInterface->create();
    }

    public function store(Request $request)
    {
        return $this->extraInterface->store($request);
    }

    public function edit(Extra $extra)
    {
        return $this->extraInterface->edit($extra);
    }

    public function update(Request $request, Extra $extra)
    {
        return $this->extraInterface->update($request, $extra);
    }

    public function destroy(Extra $extra)
    {
        return $this->extraInterface->destroy($extra);
    }
}
