<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::latest()->paginate(10);
        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required|unique:brands|max:255',
        ]);

        Brand::create([
            'name' => $request->name,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.brands.index')->with('success', 'برند با موفقیت ایجاد شد.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        return view('admin.brands.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        request()->validate([
            'name' => 'required|unique:brands,name,' . $brand->id . '|max:255',
        ]);

        $brand->update([
            'name' => $request->name,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.brands.index')->with('success', 'برند با موفقیت ویرایش شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->route('admin.brands.index')->with('success', 'برند با موفقیت حذف شد.');
    }
}
