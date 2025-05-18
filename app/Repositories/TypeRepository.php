<?php

namespace  App\Repositories;

use App\Models\Type;
use App\Services\Contracts\TypeInterface;
use Illuminate\Http\Request;
use App\DataTables\Dashboard\Admin\TypeDataTable;

class TypeRepository implements TypeInterface
{
    public function index(TypeDataTable $typeDataTable) {
        return $typeDataTable->render('dashboard.admin.types.index', ['pageTitle' => 'الانواع']);
    }

    public function create()
    {
        return view('dashboard.admin.types.create', ['pageTitle' => 'الانواع']);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        Type::create([
            'name' => $request->name,
        ]);
        return redirect()->route('admin.types.index')->with('success', 'تم حفظ بنجاح!');
    }

    public function edit(Type $type)
    {
        return view('dashboard.admin.types.edit', ['pageTitle' => 'تعديل نوع', 'extra' => $type]);
    }

    public function update(Request $request, Type $type)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $type->update([
            'name' => $request->name,
        ]);
        return redirect()->route('admin.types.index')->with('success', 'تم حفظ بنجاح!');
    }

    public function destroy(Type $type)
    {
        $type->delete();
        return redirect()->route('admin.types.index')->with('success', 'تم الحذف بنجاح!');
    }
}
