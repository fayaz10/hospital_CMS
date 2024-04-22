<?php

namespace App\Http\Controllers\Student;

use App\Models\Student\Contact;
use App\Models\Student\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Course\CourseSubName;
use App\Models\Student\Guardian;
use App\Models\Student\Address;

class StudentController extends Controller
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

        $students = Student::paginate($limit);
        return view('student-module.student.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
//        $course_sub_names = CourseSubName::all();
        return view('student-module.student.create', compact('course_sub_names'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $request->validate([
            'name_dr' => 'required',
            'father_name_dr' => 'required',
            'grand_father_name_dr' => 'required',
            'student_photo' => 'required|image|mimes:png,jpeg',
            'province' => 'required',
            'village' => 'required',
            'district' => 'required',
            'guardian_name' => 'required',
            'guardian_relation' => 'required',
            'guardian_number' => 'required',
            'tazkira_id' => 'required'
        ], [
            'name_dr.required' => 'اسم شاگرد ضرور است',
            'father_name_dr.required' => 'اسم پدر شاگرد ضرور است',
            'grand_father_name_dr.required' => 'ولدیت ضرور است',
            'student_photo.required' => 'عکس شاگرد ضرور است',
            'province.required' => 'نام صنف ضرور است',
            'village.required' => 'ولایت ضرور است',
            'district.required' => 'ولسوالی ضرور است',
            'guardian_name.required' => 'ناحیه سکونت ضرور است',
            'guardian_relation.required' => 'اسم ولی شاگرد ضرور است',
            'guardian_number.required' => 'قرابت ولی با شاگرد ضرور است',
            'tazkira_id.required' => 'شماره سکوک تذکیره ضرور است'
        ]);

        $student_photo = '';
        if ($request->student_photo) {
            $student_photo = uniqid() . '.' . $request->student_photo->getClientOriginalExtension();
            $request->student_photo->move(public_path('student_pic/photos'), $student_photo);
        }

        $student = new Student;
        $student->tazkira_id = $request->tazkira_id;

        $student->name_dr = $request->name_dr;
        $student->father_name_dr = $request->father_name_dr;
        $student->grand_father_name_dr = $request->grand_father_name_dr;

        $student->name_en = $request->name_en;
        $student->father_name_en = $request->father_name_en;
        $student->grand_father_name_en = $request->grand_father_name_en;

        $student->dob_en = $request->dob_en;
        $student->dob_dr = $request->dob_dr;

        $student->photo = $student_photo;
        $student->user_id = auth()->id();

        $student->save();

        $address = new Address;
        $address->province = $request->province;
        $address->village = $request->village;
        $address->district = $request->district;
        $address->street_number = $request->street_number;
        $address->house_number = $request->house_number;
        $address->considerations = $request->considerations;

        $student->address()->save($address);

        $guardian = new Guardian;
        $guardian->name = $request->guardian_name;
        $guardian->relation = $request->guardian_relation;

        $student->guardian()->save($guardian);

        if ($request->filled('student_email'))
            $student->contacts()->save(new Contact(['type' => 'email', 'contact' => $request->student_email]));

        if ($request->filled('student_number_1'))
            $student->contacts()->save(new Contact(['type' => 'mobile', 'contact' => $request->student_number_1]));

        if ($request->filled('student_number_2'))
            $student->contacts()->save(new Contact(['type' => 'mobile', 'contact' => $request->student_number_2]));


        if ($request->filled('guardian_number'))
            $guardian->contacts()->save(new Contact(['type' => 'mobile', 'contact' => $request->guardian_number]));

        if ($request->filled('guardian_number_1'))
            $guardian->contacts()->save(new Contact(['type' => 'mobile', 'contact' => $request->guardian_number_1]));

        if ($request->filled('guardian_email'))
            $guardian->contacts()->save(new Contact(['type' => 'email', 'contact' => $request->guardian_email]));

        return redirect(route('student.index'));


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin\Student\Student $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        return view('student-module.student.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin\Student\Student $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
//        $course_sub_names = CourseSubName::where('id', '!=', $student->student_class->id)->get();
        return view('student-module.student.edit', compact('student', 'course_sub_names'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Admin\Student\Student $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'student_name' => 'required',
            'student_father_name' => 'required',
            'student_grandfather_name' => 'required',
            'student_photo' => 'image|mimes:png,jpeg',
            'course_sub_name_id' => 'required',
            'province' => 'required',
            'district' => 'required',
            'region' => 'required',
            'student_guardian_name' => 'required',
            'student_guardian_relationship' => 'required',
            'student_guardian_mobile_number' => 'required',
            'third_person_mobile_number' => 'required'
        ], [
            'student_name.required' => 'اسم شاگرد ضرور است',
            'student_father_name.required' => 'اسم پدر شاگرد ضرور است',
            'student_grandfather_name.required' => 'ولدیت ضرور است',
            'stduent_photo.required' => 'عکس شاگرد ضرور است',
            'course_sub_name_id.required' => 'نام صنف ضرور است',
            'province.required' => 'ولایت ضرور است',
            'district.required' => 'ولسوالی ضرور است',
            'region.required' => 'ناحیه سکونت ضرور است',
            'student_guardian_name.required' => 'اسم ولی شاگرد ضرور است',
            'student_guardian_relationship.required' => 'قرابت ولی با شاگرد ضرور است',
            'student_guardian_mobile_number.required' => 'شماره تماس ولی شاگرد ضرور است',
            'third_person_mobile_number.required' => 'نمبر ارتباط شخص سومی ضرور است'
        ]);
        $student_photo = '';
        if ($request->student_photo) {
            $student_photo = uniqid() . '.' . $request->student_photo->getClientOriginalExtension();
            $request->student_photo->move(public_path('student/photos'), $student_photo);
        }

        $student = Student::find($student->id);
        $student->student_name = $request->student_name;
        $student->student_father_name = $request->student_father_name;
        $student->student_grandfather_name = $request->student_grandfather_name;
        if ($student_photo) {
            $student->student_photo = $student_photo;
        }

        $student->student_email = $request->student_email;
        $student->student_mobile_number = $request->student_mobile_number;
        $student->course_sub_name_id = $request->course_sub_name_id;
        $student->save();

        $student_address = $student->student_address;
        $student_address->province = $request->province;
        $student_address->district = $request->district;
        $student_address->region = $request->region;
        $student_address->street_number = $request->street_number;
        $student_address->house_number = $request->house_number;

        $student_address->save();


        $student_guardian = $student->student_guardian;
        $student_guardian->student_guardian_name = $request->student_guardian_name;
        $student_guardian->stduent_guardian_mobile_number = $request->student_guardian_mobile_number;
        $student_guardian->student_guardian_relationship = $request->student_guardian_relationship;
        $student_guardian->third_person_mobile_number = $request->third_person_mobile_number;

        $student_guardian->save();


        return redirect(route('student.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin\Student\Student $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
//        Student::find($student->id)->delete();
        return redirect(route('student.index'));
    }

    public function json($option = null)
    {
        $students = null;

//        return response()->json(['data' => request()->all()]);

        if (request()->has('tazkira_id') && $option == 'admission'){
            $students = Student::select(['id', 'name_dr', 'father_name_dr', 'tazkira_id', 'last_name_dr'])
                ->where('tazkira_id', 'like', '%' . request()->tazkira_id . '%')
                ->withCount(['classes' => function ($query) {
                    $query->where('courses.id','=' ,request()->course_id);
                }])
                ->get()
                ->toJson();

            return $students;
        }

        //search based of tazkira ID
        if (request()->has('tazkira_id'))
            $students = Student::select(['id', 'name_dr', 'father_name_dr', 'tazkira_id', 'last_name_dr'])
                ->where('tazkira_id', 'like', '%' . request()->tazkira_id . '%')
                ->get()
                ->toJson();

        return $students;
    }
}
