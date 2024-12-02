<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::latest()->paginate(10);

        return view('admin.attributes.index', compact('attributes'));
    }

    public function create()
    {
        return view('admin.attributes.create');
    }

    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
        ]);

        Attribute::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.attributes.index')->with('success', 'ویژگی با موفقیت ایجاد شد.');
    }

    public function show(Attribute $attribute)
    {

    }

    public function edit(Attribute $attribute)
    {

    }

    public function update(Request $request, Attribute $attribute)
    {

    }

    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return redirect()->route('admin.attributes.index')->with('success', 'ویژگی با موفقیت حذف شد.');
    }
}
