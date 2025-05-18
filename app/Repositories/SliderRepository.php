<?php

namespace  App\Repositories;

use App\Models\Slider;
use App\Services\Contracts\SliderInterface;
use Illuminate\Http\Request;
use App\DataTables\Dashboard\Admin\SliderDataTable;

class SliderRepository implements SliderInterface
{
    public function index(SliderDataTable $sliderDataTable) {
        return $sliderDataTable->render('dashboard.admin.sliders.index', ['pageTitle' => 'الصور المتحركه']);
    }

    public function create()
    {
        return view('dashboard.admin.sliders.create', ['pageTitle' => 'إضافة صوره']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $slider =Slider::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        if ($request->hasFile('slider'))
            $slider->uploadMedia($request->file('slider'), 'slider', 'root');
        return redirect()->route('admin.sliders.index')->with('success', 'تم حفظ الصوره بنجاح!');
    }
}
