<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    //
    public function Courses(){
        return $this->belongsToMany('App\Models\Course\Course','table_subject_courses');
    }
}
