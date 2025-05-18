<?php

namespace App\Services\Contracts;

use App\DataTables\Dashboard\Admin\ExtraDataTable;
use Illuminate\Http\Request;
use App\Models\Extra;

interface ExtraInterface
{
    public function index(ExtraDataTable $extraDataTable);
    public function create();
    public function store(Request $request);
    public function edit(Extra $extra);
    public function update(Request $request, Extra $extra);
    public function destroy(Extra $extra);
}
