<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::latest()->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'display_name' => 'required|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'int|exists:permissions,id'
        ], [], [
            'permissions' => 'مجوز‌های دسترسی'
        ]);

        DB::beginTransaction();
        try {
            $role = Role::create([
                'name' => $request->name,
                'display_name' => $request->display_name,
                'guard_name' => 'web'
            ]);

            $permissions = filled($request->permissions) ? Permission::whereIn('id', $request->permissions)->pluck('name') : null;
            $role->givePermissionTo($permissions);

            DB::commit();

            return redirect()->route('admin.roles.index')->with('success', 'نقش با موفقیت ثبت شد');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error storing permission: ' . $e->getMessage());
            return redirect()->back()->with('error', 'مشکلی در ثبت نقش رخ داده است، لطفا دوباره سعی کنید');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'display_name' => 'required|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'int|exists:permissions,id'
        ], [], [
            'permissions' => 'مجوز‌های دسترسی'
        ]);

        DB::beginTransaction();
        try {
            $role->update([
                'name' => $request->name,
                'display_name' => $request->display_name,
                'guard_name' => 'web'
            ]);

            $permissions = filled($request->permissions) ? Permission::whereIn('id', $request->permissions)->pluck('name') : null;
            $role->syncPermissions($permissions);

            DB::commit();

            return redirect()->route('admin.roles.index')->with('success', 'نقش با موفقیت ویرایش شد');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating role: ' . $e->getMessage());
            return redirect()->back()->with('error', 'مشکلی در ویرایش نقش رخ داده است، لطفا دوباره سعی کنید');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        DB::beginTransaction();
        try {
            $role->delete();
            DB::commit();
            return redirect()->route('admin.roles.index')->with('success', 'نقش با موفقیت حذف شد');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting role: ' . $e->getMessage());
            return redirect()->back()->with('error', 'مشکلی در حذف نقش رخ داده است، لطفا دوباره سعی کنید');
        }
    }
}
