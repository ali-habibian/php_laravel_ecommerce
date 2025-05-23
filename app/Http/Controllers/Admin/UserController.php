<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
//        $permissionIdsAssignedToUserRole = $user->roles->pluck('id')->toArray();
//        $permissions = Permission::whereNotIn('id', $permissionIdsAssignedToUserRole)->get();

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('admin.users.edit', compact('user', 'roles', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'nullable|ir_mobile:zero',
            'role' => 'nullable|int|exists:roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'int|exists:permissions,id'
        ], [], [
            'mobile' => 'شماره تلفن همراه',
            'role' => 'نقش کاربری',
            'permissions' => 'مجوز‌های دسترسی'
        ]);

        DB::beginTransaction();
        try {
            $user->update([
                'name' => $request->name,
                'mobile' => $request->mobile,
            ]);

            $roleName = Role::find($request->role)?->name;
            $user->syncRoles($roleName);

            $permissions = filled($request->permissions) ? Permission::whereIn('id', $request->permissions)->pluck('name') : null;
            $user->syncPermissions($permissions);

            DB::commit();
            return redirect()->route('admin.users.index')->with('success', 'کاربر با موفقیت ویرایش شد');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'مشکلی در ویرایش کاربر رخ داده است، لطفا دوباره سعی کنید');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
