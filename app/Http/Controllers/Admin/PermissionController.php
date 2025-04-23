<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::latest()->paginate(10);

        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'display_name' => 'required|string|max:255',
        ]);

        try {
            Permission::create([
                'name' => $request->name,
                'display_name' => $request->display_name,
                'guard_name' => 'web'
            ]);

            return redirect()->route('admin.permissions.index')->with('success', 'مجوز با موفقیت ثبت شد');
        } catch (\Exception $e) {
            Log::error('Error storing permission: ' . $e->getMessage());
            return redirect()->back()->with('error', 'مشکلی در ثبت مجوز رخ داده است');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,'.$permission->id,
            'display_name' => 'required|string|max:255',
        ]);

        try {
            $permission->update([
                'name' => $request->name,
                'display_name' => $request->display_name,
                'guard_name' => 'web'
            ]);

            return redirect()->route('admin.permissions.index')->with('success', 'مجوز با موفقیت ویرایش شد');
        } catch (\Exception $e) {
            Log::error('Error editing permission: ' . $e->getMessage());
            return redirect()->back()->with('error', 'مشکلی در ویرایش مجوز رخ داده است، لطفا دوباره سعی کنید');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        try {
            $permission->delete();

            return redirect()->route('admin.permissions.index')->with('success', 'مجوز با موفقیت حذف شد');
        } catch (\Exception $e) {
            Log::error('Error deleting permission: ' . $e->getMessage());
            return redirect()->route('admin.permissions.index')->with('error', 'مشکلی در حذف مجوز رخ داده است، لطفا دوباره سعی کنید');
        }
    }
}
