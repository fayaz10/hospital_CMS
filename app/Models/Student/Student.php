<?php

namespace App\Models\Student;

use App\Models\Course\Course;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';

    protected $fillable = [
        'tazkira_id',
        'name_dr',
        'name_en',
        'last_name_dr',
        'last_name_en',
        'father_name_dr',
        'father_name_en',
        'grand_father_name_dr',
        'grand_father_name_en',
        'dob_en',
        'dob_dr',
        'photo'
    ];

    public function classes(){
        return $this->belongsToMany('App\Models\Course\Course','admissions')
            ->withPivot('discount')
            ->withTimestamps();;
    }

    public function guardian(){
        return $this->belongsToMany('App\Models\Student\Guardian', 'guardian_student');
    }

    public function address(){
        return $this->morphMany('App\Models\Student\Address', 'addressable');
    }

    public function contacts(){
        return $this->morphMany('App\Models\Student\Contact', 'contactable');
    }

    public function fees()
    {
        return $this->hasMany('App\Models\FinanceModule\FeesPayment', 'student_id');
    }

    public function paidFees($courseId, $latest = true, $lastOne = false)
    {
        $paidFees = $this->fees()->where('class_id', $courseId)->with('course.fees', 'profit');

        if ($latest) $paidFees->latest();

        if ($lastOne) return $paidFees->first();

        return $paidFees->get();
    }

    public function paidAmount($courseId, $paidFees = null)
    {
        $paymentToCourse = $paidFees ? $paidFees :$this->paidFees($courseId);

        if (!$paymentToCourse) return null;
        //sum of all payment amount

        $allPaymentAmounts = $paymentToCourse->sum(function ($fees) {
            return $fees->profit->amount;
        });

        return $allPaymentAmounts;
    }

    public function paidAmountInPercentage($courseId, Course $course = null, $paidFees = null)
    {
        //get the related course
        $course = $course ? $course : $this->classes()->find($courseId);

        if (!$course) return null;

        $paidAmount = $this->paidAmount($courseId, $paidFees);

        // get total fees amount of course
        $courseFees = $course->fees->amount;

        // calculate the percentage
        $percentage = ($paidAmount * 100) / $courseFees;

        return $percentage;
    }
}
