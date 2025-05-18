<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\Dashboard\Admin\SizeDataTable;
use App\Dto\SizeDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\SizeRequests\CreateRequest;
use App\Services\Facades\SizeFacade;

class SizeController extends Controller
{
    public function index(SizeDataTable $sizeDataTable)
    {
        return SizeFacade::index($sizeDataTable);
    }

    public function create()
    {
        return view('dashboard.admin.sizes.create', ['pageTitle' => trans('dashboard/admin.size.create_size')]);
    }

    public function store(CreateRequest $request)
    {
        $sizeDto = SizeDto::create($request);
        SizeFacade::store($sizeDto);

        return redirect()->route('admin.sizes.index')->with('success', trans('dashboard/general.create_success'));
    }

    public function edit($id)
    {
        $size = SizeFacade::find($id);

        return view('dashboard.admin.sizes.edit', compact('size'));
    }

    public function update(CreateRequest $request, $id)
    {
        $sizeDto = SizeDto::create($request);
        SizeFacade::update($sizeDto, $id);

        return redirect()->route('admin.sizes.index')->with('success', trans('dashboard/general.update_success'));
    }

    public function destroy($id)
    {
        SizeFacade::destroy($id);

        return redirect()->route('admin.sizes.index')->with('success', trans('dashboard/general.delete_success'));
    }
}
