<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Model;

class CourseSubName extends Model
{
    //

    public function course(){
        return $this->belongsTo('App\Models\Course\Course');
    }


    public function students(){
        return $this->hasMany('App\Models\Student\Student');
    }
}
