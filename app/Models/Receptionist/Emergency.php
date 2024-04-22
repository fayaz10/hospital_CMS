<?php

namespace App\Models\Receptionist;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Emergency extends Model
{
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'emergency';

    protected $fillable = [
        'doctor_id',
        'reason',
        'patient_name',
        'registrar_id',
        'patient_id',
        'discount',
        'membership_id',
    ];

    protected static $logAttributes = ['*'];

    protected static $logName = 'Emergency\'s Logs';

    public function profit()
    {
        return $this->morphOne('App\Models\FinanceModule\Income', 'profitable');
    }
    
    public function patient()
    {
        return $this->belongsTo('App\Models\Receptionist\Patient', 'patient_id');
    }

    public function registrar()
    {
        return $this->belongsTo('App\User', 'registrar_id');
    }

    public function doctor()
    {
        return $this->belongsTo('App\Models\Receptionist\Doctor', 'doctor_id');
    }

}
