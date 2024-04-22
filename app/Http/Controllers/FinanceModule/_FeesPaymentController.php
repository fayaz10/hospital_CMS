<?php

namespace App\Http\Controllers\FinanceModule;

use App\Models\Course\Course;
use App\Models\FinanceModule\Currency;
use App\Models\FinanceModule\FeesPayment;
use App\Models\FinanceModule\Income;
use App\Models\FinanceModule\PaymentMethod;
use App\Models\Student\Student;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeesPaymentController extends Controller
{
    public function index()
    {
        // get the limits for pagination
        $limit = request()->has('limit') && request()->input('limit') <= 200 ? request()->input('limit') : 30;

        $fees = FeesPayment::with([
            'profit.currency',
            'course',
            'student'
        ])->latest()
            ->paginate($limit);

        return view('finance-module.fees-payment.index', compact('fees'));
    }

    public function create(Course $class = null, Student $student = null)
    {
        $class->load(['fees', 'students']);
        $currency = Currency::all();
        $paymentMethods = PaymentMethod::all();

        return view('finance-module.fees-payment.create', compact('class', 'currency', 'paymentMethods', 'student'));
    }

    public function store(Course $class)
    {
        $this->validate(request(), [
            'student_id' => 'required|numeric',
            'payment_date' => 'required|date',
            'valid_date' => 'required|date',
            'expire_date' => 'required|date|after:valid_date',
            'amount' => 'required|numeric|gt:1',
            'currency_id' => 'required|numeric',
            'payment_method_id' => 'required|numeric',
            'discount' => 'nullable|numeric|between:1,100',
            'punishment' => 'nullable|numeric',
            'recipient' => 'required',
        ]);

        // Find the student
//        $student = Student::find(request()->student_id);

        request()->request->add(['class_id' => $class->id, 'registrar_id' => auth()->id()]);

        $newFees = FeesPayment::create(request()->only([
            'valid_date', 'expire_date', 'student_id', 'class_id', 'discount', 'punishment', 'considerations'
        ]));

        if(request()->has('punishment'))
            request()->merge([
                'amount' => request()->amount + request()->punishment
            ]);

        $newIncome = new Income(request()->only([
            'payment_date', 'amount', 'currency_id', 'payment_method_id', 'recipient', 'registrar_id'
        ]));

        // save the all incomes
        $newFees->profit()->save($newIncome);

        // save the attachments
        if (request()->hasFile('attachments')) {

            foreach (request()->attachments as $attachment) {

                $name = 'maksys_att' . '_' . $newIncome->id . 'AG' . time();

                $fullPath = \Storage::disk('FinanceModule')->putFile($name, new File($attachment));

                $newIncome->attachments()->create([
                    'label' => $attachment->getClientOriginalName(),
                    'path' => $fullPath,
                    'mime_type' => $attachment->getClientOriginalExtension(),
                ]);
            }
        }

        return redirect(url('/finance/fees/' . $newFees->id))->with([
            'alert' => "Successfully Fees added.",
            'class' => 'alert-info'
        ]);
    }

    public function show(FeesPayment $fee)
    {
        $fee->load([
            'profit.currency',
            'profit.paymentMethod',
            'profit.registrar',
            'student',
            'course',
            'student'
        ]);
        return view('finance-module.fees-payment.show', compact('fee'));
    }
}
