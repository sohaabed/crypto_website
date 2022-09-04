<?php

namespace App\Http\Controllers\Web\UserManagement;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

//custom Spatie\Permission
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::whereNotIn('name', ['admin'])->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($artist) {
                    $url = asset($artist->image);
                    return '<img src="' . $url . '" border="0" width="40" align="center" class="rounded" />';
                })
                ->addColumn('action', function ($user) {
                    $btn = '<a href="' . route('impersonate', $user->id) . '" href="javascript:void(0)" class="btn btn-info btn-sm">impersonate</a>';
                    $btn .= '<a href="' . route('users.showRoles', $user) . '" href="javascript:void(0)" class="btn btn-info btn-sm"><i class="fas fa-lock"></i></a>';
                    $btn .= '<a href="' . route('users.show', $user) . '" href="javascript:void(0)" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>';
                    $btn .= '<a href="' . route('users.edit', $user) . '" href="javascript:void(0)" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>';
                    $btn .= '
                    <form style="display:inline" action="' . route('users.destroy', $user->id) . '" method="POST">
                    ' . csrf_field() . '
                    ' . method_field("DELETE") . '
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are You Sure Want to Delete?\')">
                      <i class="fas fa-trash-alt"></i>
                       </button>
                   </form>
                ';

                    return $btn;
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }
        return view('Layouts.Admin.users.index');
//        $data = User::whereNotIn('name', ['admin'])->get();
//        return view('Layouts.Admin.users.index', compact('data'))
//            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create()
    {

        return view('Layouts.Admin.users.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
            'password' => 'required|min:8|same:confirm-password',
            'file' => 'nullable|mimes:png,jpg,jpeg,gif',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
        if ($request->hasFile('file')) {
            $logo = $request['file'];
            $fileName = date('Y-m-d') . $logo->getClientOriginalName();
            $pathImage = $request['file']->storeAs('users_image', $fileName, 'public');
            $request['image'] = 'storage/' . $pathImage;
        }

        $user = User::create(array_merge(
            $validator->validated(),
            [
                'password' => bcrypt($request->password),
                'image' => $request['image'],
            ]
        ));
        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    public function show(User $user)
    {
        return view('Layouts.Admin.users.show',
            compact('user'));
    }

    public function showRoles(User $user)
    {
        $roles = Role::where('name', '!=', 'admin')->get();
        $permissions = Permission::all();
        return view('Layouts.Admin.users.role',
            compact('user', 'roles', 'permissions'));
    }

    public function edit(User $user)
    {
        return view('Layouts.Admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required | email | unique:users,email,' . $user->id,
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
            'file' => 'nullable|mimes:png,jpg,jpeg,gif',
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $request->validate([
                'password' => 'min:8|same:confirm-password',
            ]);
            $input['password'] = bcrypt($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }
        if ($request->hasFile('file')) {
            $logo = $input['file'];
            $fileName = date('Y-m-d') . $logo->getClientOriginalName();
            $pathImage = $input['file']->storeAs('users_image', $fileName, 'public');
            $input['image'] = 'storage/' . $pathImage;

        }

        $user->update($input);


        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        if ($user->hasRole('admin')) {
            return back()->with('message', 'you are admin.');
        }
        User::destroy($user->id);


        return back()->with('message', 'User deleted.');

    }

    public function assignRole(Request $request, User $user)
    {
        if ($user->hasRole($request->role)) {
            return back()->with('message', 'Role exists.');
        }

        $user->assignRole($request->role);
        return back()->with('message', 'Role assigned.');
    }

    public function removeRole(User $user, Role $role)
    {
        if ($user->hasRole($role)) {
            $user->removeRole($role);
            return back()->with('message', 'Role removed.');
        }

        return back()->with('message', 'Role not exists.');
    }


    public function givePermission(Request $request, User $user)
    {
        if ($user->hasPermissionTo($request->permission)) {
            return back()->with('message', 'Permission Exists.');
        }
        $user->givePermissionTo($request->permission);
        return back()->with('message', 'Permission Added.');


    }

    public function revokePermission(User $user, Permission $permission)
    {
        if ($user->hasPermissionTo($permission)) {
            $user->revokePermissionTo($permission);
            return back()->with('message', 'Permission Revoked.');
        }
        return back()->with('message', 'Permission Not Exists.');


    }

    public function impersonate($id)
    {

        Session::put(['impersonate' => $id, 'admin' => Auth::id()]);
        Auth::loginUsingId($id);

        return redirect()->route('home');
    }


    public function impersonate_back()
    {
        Auth::logout();
        Auth::loginUsingId(Session::get('admin'));
        Session::forget('impersonate');
        return redirect()->route('home');
    }
}
