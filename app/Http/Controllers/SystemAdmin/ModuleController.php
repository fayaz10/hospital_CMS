<?php

namespace App\Http\Controllers\SystemAdmin;

use App\Http\Controllers\Controller;
use App\Models\SystemAdmin\Module;
use App\User;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    //
    public function index()
    {
        // get the limits for pagination
        $limit = request()->has('limit') && request()->input('limit') <= 200 ? request()->input('limit') : 50;

        $mod = Module::paginate($limit);
        return view('system-admin.module.index',compact('mod'));
    }

    public function show(Module $module)
    {
        return view('system-admin.module.show', compact('module'));
    }

    public function create()
    {
        return view('system-admin.module.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'module_code' => 'required|min:5',
            'path' => 'required|min:3',
            'name_en' => 'required|min:4',
            'name_dr' => 'required|min:4',
            'name_pa' => 'required|min:4',
        ]);

        $module = Module::create([
            'module_code' => $request->module_code,
            'path' => $request->path,
            'name_en' => $request->name_en,
            'name_dr' => $request->name_dr,
            'name_pa' => $request->name_pa,
            'user_id' => auth()->id()
        ]);

        return redirect('/admin/module/' . $module->id)->with(
            [
                'alert' => 'created',
                'class' => 'alert-info'
            ]
        );
    }

    public function edit(Module $module)
    {
        return view('system-admin.module.edit', compact('module'));
    }

    public function update(Module $module, Request $request)
    {
        $this->validate($request, [
            'module_code' => 'required',
            'path' => 'required',
            'name_en' => 'required',
            'name_dr' => 'required',
            'name_pa' => 'required',
        ]);

        $module->update($request->all());

        return redirect(url('/admin/module/'.$module->id))->with([
            'alert' => "edited",
            'class' => 'alert-brand'
        ]);
    }

    public function assign(Request $request)
    {
        $module = Module::find($request->input('module'));
        $user = User::find($request->input('user'));
        $module->users()->toggle([$user->id]);

        return $module->roles;
    }
}
