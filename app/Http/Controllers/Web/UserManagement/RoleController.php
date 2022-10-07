<?php

namespace App\Http\Controllers\Web\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    function __construct()
    {
        // $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);
        //$this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        //$this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        //$this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $roles = Role::whereNotIn('name', ['admin'])->paginate(5);
        return view('Layouts.Admin.roles.index', compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }


    public function create()
    {
        $permissions = Permission::all();
        return view('Layouts.Admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
//            'permission' => 'required',
        ]);

        $role = Role::create(['name' => $request->input('name')]);
//        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')
            ->with('success', 'Role created successfully');
    }

    public function show($id)
    {
        $role = Role::find($id);
//        $rolePermissions = Permission::join('role_has_permissions',
//            'role_has_permissions . permission_id', ' = ', 'permissions . id')
//            ->where('role_has_permissions . role_id', $id)
//            ->get();

        return view('Layouts.Admin.roles.show', compact('role'));
    }

    public function edit(Role $role)
    {

        $permissions = Permission::all();
//        $rolePermissions = DB::table('role_has_permissions')->where('role_has_permissions . role_id', $id)
//            ->pluck('role_has_permissions . permission_id', 'role_has_permissions . permission_id')
//            ->all();

        return view('Layouts.Admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
//            'permission' => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

//        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully');
    }

    public function destroy($id)
    {
        Role::destroy($id);
        return back()->with('message', 'Role deleted.');
    }

    public function givePermission(Request $request, Role $role)
    {
        if ($role->hasPermissionTo($request->permission)) {
            return back()->with('message', 'Permission Exists.');
        }
        $role->givePermissionTo($request->permission);
        return back()->with('message', 'Permission Added.');


    }

    public function revokePermission(Role $role, Permission $permission)
    {
        if ($role->hasPermissionTo($permission)) {
            $role->revokePermissionTo($permission);
            return back()->with('message', 'Permission Revoked.');
        }
        return back()->with('message', 'Permission Not Exists.');


    }


}
