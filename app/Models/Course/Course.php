<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function course_sub_names(){
        return $this->hasMany('App\Models\Course\CourseSubName');
    }

    public function subjects(){
        return $this->belongsToMany('App\Models\Course\Subject','course_subject');
    }

    public function students(){
        return $this
            ->belongsToMany('App\Models\Student\Student','admissions')
            ->withPivot('discount')
            ->withTimestamps();
    }

    public function fees(){
        return $this->morphOne('App\Models\Course\Fees', 'payable');
    }
}
