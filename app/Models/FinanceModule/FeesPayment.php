<?php

namespace App\Models\FinanceModule;

use App\Models\Course\Course;
use App\Models\Student\Student;
use Illuminate\Database\Eloquent\Model;

class FeesPayment extends Model
{
    protected $table = "fees_payment";

    protected $appends = ['duration', 'valid_duration', 'valid_status'];

    protected $fillable = [
        'student_id', 'class_id', 'valid_date', 'expire_date', 'discount', 'punishment', 'considerations'
    ];

    protected $dates = [
        'valid_date',
        'expire_date',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the Fees's profitable.
     */
    public function profit()
    {
        return $this->morphOne(Income::class, 'profitable');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function Course()
    {
        return $this->belongsTo(Course::class, 'class_id');
    }

    public function getDurationAttribute()
    {
        return $this->expire_date->diffInDays($this->valid_date);
    }

    public function getValidDurationAttribute()
    {
        return $this->expire_date->diffInDays(now());
    }

    public function getValidStatusAttribute()
    {
        return $this->expire_date->gte(now());
    }
}
