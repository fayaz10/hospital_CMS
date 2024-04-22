<?php

namespace App\Http\Controllers\LabModule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LabModule\SubTest;

class SubTestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $limit = request()->has('limit') && request()->input('limit') <= 200 ? request()->input('limit') : 50;

        $tests = SubTest::with('tests')
            ->latest()
            ->paginate($limit);

        return view('lab-module.sub-test.index', compact('tests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('lab-module.sub-test.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
        ]);

        $newTest = SubTest::create([
            'name' => request()->name,
            'range' => request()->range,
        ]);

        if(request()->filled('tests'))
            $newTest->tests()->attach(request()->tests);

        return redirect(route('sub-test.index'))
            ->with([
                'alert' => "created",
                'class' => 'alert-info',
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(SubTest $sub_test)
    {
        return view('lab-module.sub-test.edit', compact('sub_test'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubTest $sub_test)
    {
        $this->validate(request(), [
            'name' => 'required',
        ]);

        $sub_test->update([
            'name' => request()->name,
            'range' => request()->range,
        ]);

        // if(request()->filled('tests'))
        $sub_test->tests()->sync(request()->tests);

        return redirect(route('sub-test.index'))
            ->with([
                'alert' => "edited",
                'class' => 'alert-info',
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
