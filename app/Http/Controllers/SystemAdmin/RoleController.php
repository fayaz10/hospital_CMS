<?php

namespace App\Http\Controllers\SystemAdmin;

use App\Http\Controllers\Controller;
use App\Models\SystemAdmin\Module;
use App\Models\SystemAdmin\Permission;
use App\Models\SystemAdmin\Role;
use App\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:sys_rol_show')->only(['index', 'show']);
        $this->middleware('permission:sys_rol_create')->only(['create', 'store']);
        $this->middleware('permission:sys_rol_edit')->only(['edit', 'update']);
    }

    public function index()
    {
        // get the limits for pagination
        $limit = request()->has('limit') && request()->input('limit') <= 200 ? request()->input('limit') : 50;

        $roles = Role::paginate($limit);
        return view('system-admin.role.index',compact('roles'));
    }

    public function show(Role $role)
    {
        return view('system-admin.role.show',compact('role'));
    }

    public function create()
    {
        return view('system-admin.role.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'label_en' => 'required|min:3',
            'label_dr' => 'required|min:3',
        ]);

        $role = Role::create($request->all());

        if($request->has('permissions'))
            $role->permissions()->sync($request->permissions);

        return redirect('/admin/role')->with(
            [
                'alert' => 'created',
                'class' => 'alert-info'
            ]
        );
    }

    public function update(Role $role, Request $request)
    {
        
        $this->validate($request, [
            'name' => 'required',
        ]);

        $role->update($request->except(['_token', '_method']));

        $role->permissions()->sync($request->permissions);

        return redirect('/admin/role/')->with(
            [
                'alert' => 'edited',
                'class' => 'alert-brand'
            ]
        );
    }

    public function edit(Role $role)
    {
        // dd(json_encode($role->permissions->pluck("id")->toArray()));
        $perm = json_encode($role->permissions->pluck("id")->toArray());
        return view('system-admin.role.edit',compact('role','perm'));
    }

    public function assign(Request $request)
    {
        $role = Role::find($request->input('role'));
        $user = User::find($request->input('user'));
        $user->roles()->toggle($role);

        return 1;
    }

    public function assignPerms(Request $request)
    {
//        dd($request->all());
        $role = Role::find($request->input('role_id'));
        if ($request->has('selected')){
            $role->permissions()->sync($request->input('selected'));
        }else{
            $role->permissions()->sync([]);
        }

        return 0;

    }

    public function createPerm(Request $request)
    {
//        dd($request->all());
        $validator = \Validator::make($request->all(), [
            'name' => 'required|min:8',
            'label_en' => 'required|min:8',
            'module_id' => 'required',
        ]);

        if ($validator->fails()) {
            return 1;
        }

        $permission = Permission::create($request->all());

        $permission->roles()->attach(Role::find($request->input('role_id')));

        return $permission;
    }
}
