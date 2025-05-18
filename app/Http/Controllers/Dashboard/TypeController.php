<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Dashboard\Admin\TypeDataTable;
use App\Services\Contracts\TypeInterface;
use App\Models\Type;

class TypeController extends Controller
{
    public function __construct(protected TypeDataTable $typeDataTable, protected TypeInterface $typeInterface)
    {
        $this->typeInterface = $typeInterface;
        $this->typeDataTable = $typeDataTable;
    }

    public function index(TypeDataTable $typeDataTable)
    {
        return $this->typeInterface->index($this->typeDataTable);
    }

    public function create()
    {
        return $this->typeInterface->create();
    }

    public function store(Request $request)
    {
        return $this->typeInterface->store($request);
    }

    public function edit(Type $type)
    {
        return $this->typeInterface->edit($type);
    }

    public function update(Request $request, Type $type)
    {
        return $this->typeInterface->update($request, $type);
    }

    public function destroy(Type $type)
    {
        return $this->typeInterface->destroy($type);
    }
}
