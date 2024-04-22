<?php

namespace App\Http\Controllers\Course;

use App\Models\Course\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get the limits for pagination
        $limit = request()->has('limit') && request()->input('limit') <= 200 ? request()->input('limit') : 30;

        $subjects = Subject::paginate($limit);
        return view('course-module.subject.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('course-module.subject.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|unique:subjects',
            'label_dr' => 'required',
            'label_en' => 'required'
        ], [
            'name.required' => 'مضمون ضرور است',
            'label_dr.required' => 'نام مضمون دری ضرور است',
            'label_en.required' => 'نام مضمون انگلیسی ضرور است',
            'name.unique' => 'این نام قبلا ثبت شده است'
        ]);

        $subject = new Subject;
        $subject->name = $request->name;
        $subject->label_dr = $request->label_dr;
        $subject->label_en = $request->label_en;
        $subject->save();
        return redirect(route('subject.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course\Subject $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course\Subject $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        //
        return view('course-module.subject.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Course\Subject $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        //

        //
        $request->validate([
            'subject_name' => 'required'
        ], [
            'subject_name.required' => 'نام مضمون ضرور است'
        ]);

        $subject = Subject::find($subject->id);
        $subject->subject_name = $request->subject_name;
        $subject->save();
        return redirect(route('subject.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course\Subject $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        //

        Subject::find($subject->id)->delete();
        return redirect(route('subject.index'));
    }
}
