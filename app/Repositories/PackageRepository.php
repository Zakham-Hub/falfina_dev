<?php

namespace  App\Repositories;

use App\Models\Package;
use App\Models\Product;
use App\Services\Contracts\PackageInterface;
use Illuminate\Http\Request;
use App\DataTables\Dashboard\Admin\PackageDataTable;

class PackageRepository implements PackageInterface
{
    public function index(PackageDataTable $packageDataTable)
    {
        return $packageDataTable->render('dashboard.admin.packages.index', ['pageTitle' => 'الباكدج']);
    }

    public function create()
    {
        $products = Product::get();
        return view('dashboard.admin.packages.create', ['pageTitle' => 'اضافه باكدج', 'products' => $products]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            'desc' => 'required|string',
            'image' => 'nullable|file',
            'product_id' => 'required|array',
            'product_id.*' => 'exists:products,id', // Ensures all product IDs exist
        ]);

        $package = Package::create([
            'name' => $request->name,
            'price' => $request->price,
            'desc' => $request->desc,
        ]);
        if ($request->hasFile('image')) {
            $package->uploadMedia($request->file('image'), 'package', 'root');
        }
        $package->products()->attach($request->product_id);
        return redirect()->route('admin.packages.index')->with('success', 'تم حفظ بنجاح!');
    }

    public function edit(Package $package)
    {
        $products = Product::with(['media'])->get();
        return view('dashboard.admin.packages.edit', ['pageTitle' => 'تعديل باكدج',  'package' => $package, 'products' => $products]);
    }

    public function update(Request $request, Package $package)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            'desc' => 'required|string',
            'image' => 'nullable|file',
            'product_id' => 'required|array',
            'product_id.*' => 'exists:products,id', // Ensures all product IDs exist
        ]);
        $package->update([
            'name' => $request->name,
            'price' => $request->price,
            'desc' => $request->desc,
        ]);
        if (isset($request->product_id)) {
            $package->products()->sync($request->product_id);
        }
        if ($request->hasFile('image')) {
            $package->updateMedia($request->file('image'), 'package', 'root');
        }
        return redirect()->route('admin.packages.index')->with('success', 'تم حفظ بنجاح!');
    }

    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->route('admin.packages.index')->with('success', 'تم الحذف بنجاح!');
    }
}
