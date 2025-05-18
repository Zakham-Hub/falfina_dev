<?php

namespace  App\Repositories;

use App\Models\{Manager,Branch};
use App\Services\Contracts\ManagerInterface;
use Illuminate\Http\Request;
use App\DataTables\Dashboard\Admin\ManagerDataTable;
use Illuminate\Support\Facades\Hash;

class ManagerRepository implements ManagerInterface
{
    public function index(ManagerDataTable $managerDataTable)
    {
        return $managerDataTable->render('dashboard.admin.managers.index', ['pageTitle' => 'مدراء الفروع']);
    }

    public function create()
    {
        $branches = Branch::pluck('name', 'id');
        return view('dashboard.admin.managers.create', ['pageTitle' => 'اضافه مدير فرع', 'branches' => $branches]);
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:managers,email',
            'phone' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'branch_id' => 'nullable|exists:branches,id',
        ]);
        $data['password'] = Hash::make($data['password']);
        Manager::create($data);
        return redirect()->route('admin.managers.index')->with('success', 'تم الحفظ بنجاح!');
    }

    public function edit(Manager $manager) {
        $manager->load('branch');
        $branches = Branch::pluck('name', 'id');
        return view('dashboard.admin.managers.edit', ['pageTitle' => 'تعديل مدير فرع ' . $manager?->name, 'manager' => $manager, 'branches' => $branches]);
    }

    public function update(Request $request, Manager $manager) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:managers,email,' . $manager->id,
            'phone' => 'required|string|max:255',
            'password' => 'nullable|string|min:6|confirmed',
            'branch_id' => 'nullable|exists:branches,id',
        ]);
        $manager->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password ? bcrypt($request->password) : $manager->password,
            'branch_id' => $request->branch_id
        ]);
        return redirect()->route('admin.managers.index')->with('success', 'تم حفظ بنجاح!');
    }

    public function destroy(Manager $manager)
    {
        $manager->delete();
        return redirect()->route('admin.managers.index')->with('success', 'تم الحذف بنجاح!');
    }
}
