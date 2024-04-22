<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    protected $table = 'guardians';

    protected $fillable = [
        'name',
        'relation',
    ];

    public function students(){
        return $this->belongsToMany('App\Models\Student\Student', 'guardian_student');
    }

    public function contacts(){
        return $this->morphMany('App\Models\Student\Contact', 'contactable');
    }
}
