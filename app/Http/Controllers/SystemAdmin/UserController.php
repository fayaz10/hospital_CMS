<?php

namespace App\Http\Controllers\SystemAdmin;

use App\Models\SystemAdmin\Module;
use App\Models\SystemAdmin\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input as Input;

class UserController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:sys_usr_show')->only(['index', 'show']);
        $this->middleware('permission:sys_usr_create')->only(['create', 'store', 'changeStatus']);
        $this->middleware('permission:sys_usr_edit')->only(['edit', 'update']);
    }

    public function index()
    {
        // get the limits for pagination
        $limit = request()->has('limit') && request()->input('limit') <= 200 ? request()->input('limit') : 30;

        $users = User::paginate($limit);
        return view('system-admin.user.index',compact('users'));
    }

    public function show(User $user)
    {
        return view('system-admin.user.show',compact('user'));
    }

    public function create()
    {
        $modules    = Module::all();
        $roles      = Role::all();
        return view('system-admin.user.create',compact('modules','roles'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'name_dr' => 'required|min:3',
            'email' => 'required|email',
            'img_path' => 'max:10000',
            ]);

        $user = User::create([
            'name' => $request->name,
            'name_dr' => $request->name_dr,
            'email' => $request->email,
            'password' => $request->filled('password') ? bcrypt($request->password) : bcrypt('asdf1234'),
            // 'status' => 1,
            'user_id' => auth()->id(),
            'img_path' => Input::hasFile('img_path')
                ? Input::file('img_path')->move('user_pic',  $request->email.'.'. Input::file('img_path')->getClientOriginalExtension())
                : null ,
        ]);

        if($request->has('modules'))
            $user->modules()->sync($request->modules);

        if($request->has('roles'))
            $user->roles()->sync($request->roles);


        return redirect('/admin/user/' . $user->id)->with(
            [
                'alert' => 'created',
                'class' => 'alert-info'
            ]
        );
    }


    public function edit(User $user)
    {
        $modules    = Module::all();
        $roles      = Role::all();

        $perm = json_encode($user->roles->pluck("id")->toArray());
        $mod = json_encode($user->modules->pluck("id")->toArray());

        return view('system-admin.user.edit',compact('user','modules','roles','perm','mod'));
    }

    public function update(User $user, Request $request)
    {

        $this->validate($request, [
            'name' => 'required|min:3',
            'name_dr' => 'required|min:3',
            'modules' => 'required',
            'roles' => 'required',
            'email' => 'required|email',
            'img_path' => 'max:10000',
        ]);

        if (!true) throw new \App\Exceptions\CustomException('The profile\'s encoded unique string should be number.');

        $user->update($request->except(['_token','_method','img_path']));

        if ($request->hasFile('img_path'))
            $user->img_path = $request->img_path->move('user_pic',  $request->email.'.'. $request->img_path->getClientOriginalExtension());

        if($request->has('modules'))
            $user->modules()->sync($request->modules);

        if($request->has('roles'))
            $user->roles()->sync($request->roles);

        $user->save();

        return redirect(url('/admin/user/'.$user->id))->with([
            'alert' => "edited",
            'class' => 'alert-brand'
        ]);
    }

    public function reset(User $user)
    {
        $this->validate(request(), [
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
        ]);

        if (auth()->user()->can('sys_usr_reset')){
            $user->password = bcrypt(request()->password);
            $user->save();
            return back()->with([
                'alert' => "edited",
				'class' => 'alert-brand'
            ]);
        }
        return abort(401);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect(url('/admin/user/'))->with([
            'alert' => "deleted",
            'class' => 'alert-danger'
        ]);
    }

    public function setUserImage($request)
    {
//        if (Input::hasFile($request))
    }

    public function search()
    {

        if (request()->ajax())
            return User::search(request()->term)
                ->get();
    }

    public function changeStatus(User $user)
    {
        if ($user->id == auth()->id()) 
            return back()->with([
                'alert' => "You can't disable your own user.",
                'class' => 'alert-warning'
            ]);

        if(!$user->blocked_at){
            $user->blocked_user_id = auth()->id();
            $user->blocked_at = now()->format('Y-m-d H:i:s');
            $user->save();

            return back();
        }

        $user->update([
            'blocked_user_id' => null,
            'blocked_at' => null
        ]);

        return back()->with([
            'alert' => "Your action performed successfully.",
            'class' => 'alert-info'
        ]);
    }

}
