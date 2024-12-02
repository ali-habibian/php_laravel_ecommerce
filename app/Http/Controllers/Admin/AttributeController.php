<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function index()
    {
        return Attribute::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([

        ]);

        return Attribute::create($data);
    }

    public function show(Attribute $attribute)
    {
        return $attribute;
    }

    public function update(Request $request, Attribute $attribute)
    {
        $data = $request->validate([

        ]);

        $attribute->update($data);

        return $attribute;
    }

    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return response()->json();
    }
}
