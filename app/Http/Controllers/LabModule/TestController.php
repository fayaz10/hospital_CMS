<?php

namespace App\Http\Controllers\LabModule;

use App\Http\Controllers\Controller;
use App\Models\LabModule\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:lab_tes_show')->only(['index', 'show']);
        $this->middleware('permission:lab_tes_create')->only(['create', 'store']);
        $this->middleware('permission:lab_tes_edit')->only(['edit', 'update']);
    }

    public function index()
    {
        $limit = request()->has('limit') && request()->input('limit') <= 200 ? request()->input('limit') : 50;

        $tests = Test::with('currency')
            ->latest()
            ->paginate($limit);

        return view('lab-module.test.index', compact('tests'));
    }

    public function create()
    {
        return view('lab-module.test.create');
    }

    public function store()
    {

        $this->validate(request(), [
            'test_name' => 'required',
            'currency_id' => 'required',
        ]);

        $newTest = Test::create([
            'name' => request()->test_name,
            'label_en' => request()->test_nameEn,
            'label_dr' => request()->test_nameDr,
            'description_en' => request()->detailesEn,
            'description_dr' => request()->detailesDr,
            'price' => request()->test_price,
            'currency_id' => request()->currency_id,
            'duration' => request()->test_duration,
        ]);

        return redirect(route('test.show', [$newTest->id]))
            ->with([
                'alert' => "created",
                'class' => 'alert-info',
            ]);
    }

    public function show(Test $test)
    {
        if (request()->ajax()) {
            $test->load('currency');
            return $test->toJson();
        }
        return view('lab-module.test.show', compact('test'));
    }

    public function edit(Test $test)
    {
        return view('lab-module.test.edit', compact('test'));
    }

    public function update(Test $test)
    {

        $this->validate(request(), [
            'test_name' => 'required',
            'currency_id' => 'required',
        ]);

        $test->update([
            'name' => request()->test_name,
            'label_en' => request()->test_nameEn,
            'label_dr' => request()->test_nameDr,
            'description_en' => request()->detailesEn,
            'description_dr' => request()->detailesDr,
            'price' => request()->test_price,
            'currency_id' => request()->currency_id,
            'duration' => request()->test_duration,
        ]);

        // return view('pharmacist-module.prescription.show',[$newExperiment->id]);
        return redirect(route('test.show', [$test->id]))
            ->with([
                'alert' => "edited",
                'class' => 'alert-brand'
            ]);
    }

    public function search()
    {

        if (request()->ajax())
            return Test::search(request()->term)
                ->get();
    }
}
