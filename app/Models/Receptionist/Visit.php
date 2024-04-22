<?php

namespace App\Models\Receptionist;

use Illuminate\Database\Eloquent\Model;
use App\Attachment;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Visit extends Model
{
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'visits';

    protected $fillable = [
        
        'patient_id',
        'doctor_id',
        'cashier_id',
        'discount',
        'membership_id'
    ];

    protected static $logAttributes = ['*'];

    protected static $logName = 'Visit\'s Logs';


    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function profit()
    {
        return $this->morphOne('App\Models\FinanceModule\Income', 'profitable');
    }

}
