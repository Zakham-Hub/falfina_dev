<?php

namespace  App\Repositories;

use App\Models\Extra;
use App\Services\Contracts\ExtraInterface;
use Illuminate\Http\Request;
use App\DataTables\Dashboard\Admin\ExtraDataTable;

class ExtraRepository implements ExtraInterface
{
    public function index(ExtraDataTable $extraDataTable)
    {
        return $extraDataTable->render('dashboard.admin.extras.index', ['pageTitle' => 'الاضافات و الصوصات']);
    }

    public function create() {
        return view('dashboard.admin.extras.create', ['pageTitle' => 'إضافة صوص او اضافة']);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:sauce,addon',
            'price' => 'required|numeric|min:0.01',
        ]);
        $extra = Extra::create([
            'name' => $request->name,
            'type' => $request->type,
            'price' => (float) $request->price,
        ]);
        if ($request->hasFile('extra'))
            $extra->uploadMedia($request->file('extra'), 'extra', 'root');
        return redirect()->route('admin.extras.index')->with('success', 'تم حفظ بنجاح!');
    }

    public function edit(Extra $extra) {
        $extra->load('media');
        return view('dashboard.admin.extras.edit', ['pageTitle' => 'تعديل صوص او اضافة', 'extra' => $extra]);
    }

    public function update(Request $request, Extra $extra) {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:sauce,addon',
            'price' => 'required|numeric|min:0.01',
        ]);
        $extra->update([
            'name' => $request->name,
            'type' => $request->type,
            'price' => (float) $request->price,
        ]);
        if ($request->hasFile('extra'))
            $extra->updateMedia($request->file('extra'), 'extra', 'root');
        return redirect()->route('admin.extras.index')->with('success', 'تم حفظ بنجاح!');
    }

    public function destroy(Extra $extra) {
        $extra->deleteMedia('extra');
        $extra->delete();
        return redirect()->route('admin.extras.index')->with('success', 'تم الحذف بنجاح!');
    }
}