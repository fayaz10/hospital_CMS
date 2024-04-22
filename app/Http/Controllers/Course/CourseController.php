<?php

namespace App\Http\Controllers\Course;

use App\Models\Course\Course;
use App\Models\Course\Fees;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Course\Subject;
use App\Models\Course\CourseSubName;

class CourseController extends Controller
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

        $courses = Course::withCount(['subjects', 'students'])->paginate($limit);
        return view('course-module.course.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = Subject::all();
        return view('course-module.course.create', compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:courses,name',
            'label_dr' => 'required',
            'label_en' => 'required',
            'amount' => 'required',
            'currency_id' => 'required',
            'term' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ], [
            'name.required' => 'کورس یا صنف ضروری است',
            'label_dr.required' => 'نام کورس یا صنف دری ضروری است',
            'label_en.required' => 'نام کورس یا صنف انگلیسی ضروری است',
            'name.unique' => 'این نام قبلا ثبت شده است',
            'amount.required' => 'مقدار فیس ضروری است',
            'currency_id.required' => 'واحد پولی فیس ضروری است',
            'term.required' => 'دوره صنف ضروری است',
            'term.unique' => 'این دوره صنف قبلا ثبت شده است. لطفا دوره فرد انتخاب نمایید',
            'start_date.required' => 'تاریخ شروع ضروری است',
            'end_date.required' => 'تاریخ ختم ضروری است',
        ]);

        $course = new Course;
        $course->name = $request->name;
        $course->label_en = $request->label_en;
        $course->label_dr = $request->label_dr;
        $course->save();

        $course->subjects()->sync($request->subjects);

        $fees = new Fees;
        $fees->amount = $request->amount;
        $fees->term = $request->term;
        $fees->start_date = $request->start_date;
        $fees->end_date = $request->end_date;
        $fees->currency_id = $request->currency_id;
        $fees->considerations = $request->considerations;

        $course->fees()->save($fees);

        return redirect(route('course.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course\Course $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        $course->load(['fees', 'fees.currency', 'subjects', 'students']);
        return view('course-module.course.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course\Course $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        $subjects = Subject::all();
        $course->load(['fees', 'subjects']);
        return view('course-module.course.edit', compact('course', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Course\Course $course
     * @return \Illuminate\Http\Response
     */
    public function update(Course $course)
    {
        request()->validate([
            'name' => 'required|unique:courses,name,' . $course->id,
            'label_dr' => 'required',
            'label_en' => 'required',
            'amount' => 'required',
            'currency_id' => 'required',
            'term' => 'required',
//            'term' => 'required|unique:fees,term,' . $course->fees->id,
            'start_date' => 'required',
            'end_date' => 'required',
        ], [
            'name.required' => 'کورس یا صنف ضروری است',
            'label_dr.required' => 'نام کورس یا صنف دری ضروری است',
            'label_en.required' => 'نام کورس یا صنف انگلیسی ضروری است',
            'name.unique' => 'این نام قبلا ثبت شده است',
            'amount.required' => 'مقدار فیس ضروری است',
            'currency_id.required' => 'واحد پولی فیس ضروری است',
            'term.required' => 'دوره صنف ضروری است',
            'term.unique' => 'این دوره صنف قبلا ثبت شده است. لطفا دوره فرد انتخاب نمایید',
            'start_date.required' => 'تاریخ شروع ضروری است',
            'end_date.required' => 'تاریخ ختم ضروری است',
        ]);

        $course->name = request()->name;
        $course->label_en = request()->label_en;
        $course->label_dr = request()->label_dr;
        $course->save();

        $course->subjects()->sync(request()->subjects);

        $fees = $course->fees;
        $fees->amount = request()->amount;
        $fees->term = request()->term;
        $fees->start_date = request()->start_date;
        $fees->end_date = request()->end_date;
        $fees->currency_id = request()->currency_id;
        $fees->considerations = request()->considerations;

        $fees->save();

        return redirect(route('course.show', $course->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course\Course $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //
    }

    public function showAdmission(Course $course)
    {
        $course->load('fees');
        return view('course-module.course.admission', compact('course'));
    }

    public function storeAdmission(Course $course)
    {
        request()->validate([
            'student_id' => 'required',
            'discount' => 'nullable|numeric|between:1,100',

        ], [
            'student_id.required' => 'حداقل یک اسم، ضروری است',
            'discount.numeric' => 'مقدار تخفیف باید عدد باشد',
            'discount.between' => 'مقدار تخفیف بین 1 الی 100 باشد',
        ]);

        $course->students()->syncWithoutDetaching([request()->student_id => [
            'registrar_id' => auth()->id(), 'created_at' => now(), 'updated_at' => now(), 'discount' => request()->discount,
            ]]);

        return redirect(route('course.index'));
    }
}
