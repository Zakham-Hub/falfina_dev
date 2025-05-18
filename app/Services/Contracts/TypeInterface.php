<?php

namespace App\Services\Contracts;

use App\DataTables\Dashboard\Admin\TypeDataTable;
use Illuminate\Http\Request;
use App\Models\Type;
interface TypeInterface
{
    public function index(TypeDataTable $typeDataTable);
    public function create();
    public function store(Request $request);
    public function edit(Type $type);
    public function update(Request $request, Type $type);
    public function destroy(Type $type);
}
