<?php

namespace  App\Repositories;

use App\Models\Branch;
use App\Services\Contracts\BranchInterface;
use Illuminate\Http\Request;
use App\DataTables\Dashboard\Admin\BranchDataTable;

class BranchRepository implements BranchInterface
{
    public function index(BranchDataTable $branchDataTable)
    {
        return $branchDataTable->render('dashboard.admin.branches.index', ['pageTitle' => 'الفروع']);
    }

    public function create()
    {
        return view('dashboard.admin.branches.create', ['pageTitle' => 'إضافة فرع']);
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);
        Branch::create([
            'name' => $request->name,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);
        return redirect()->route('admin.branches.index')->with('success', 'تم حفظ الفرع بنجاح!');
    }

    public function edit($id)
    {
        $branch = Branch::findOrFail($id);
        return view('dashboard.admin.branches.edit', ['branch' => $branch, 'pageTitle' => 'تعديل الفرع']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);

        $branch = Branch::findOrFail($id);
        $branch->update($request->only(['name', 'latitude', 'longitude', 'address', 'phone']));
        return redirect()->route('admin.branches.index')->with('success', 'تم تحديث الفرع بنجاح!');
    }

    public function destroy(Branch $branch) {
        $branch->delete();
        return redirect()->route('admin.branches.index')->with('success', 'تم الحذف بنجاح!');
    }

}
