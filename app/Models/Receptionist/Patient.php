<?php

namespace App\Models\Receptionist;

use Illuminate\Database\Eloquent\Model;
use App\Attachment;
use App\User;
use Spatie\Activitylog\Traits\LogsActivity;
use Laravel\Scout\Searchable;

class Patient extends Model
{
    use LogsActivity;
    use Searchable;

    protected $table = 'patients';

    protected $fillable = [
        
        'name',
        'sex',
        'age',
        'record_no',
        'phone_no',
        'address',
        'tazkira',
        'registrar_id',
        'photo',
    ];

    protected static $logAttributes = ['*'];

    protected static $logName = 'Patient\'s Logs';

    public function registrar()
    {
        return $this->belongsTo(User::class, 'registrar_id');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function visits()
    {
        return $this->hasMany('App\Models\Receptionist\Visit', 'patient_id');
    }

    public function emergencies()
    {
        return $this->hasMany('App\Models\Receptionist\Emergency', 'patient_id');
    }

    public function din()
    {
        return $this->hasMany('App\Models\FinanceModule\DiverseIncome', 'patient_id');
    }

    public function prescriptions()
    {
        return $this->hasMany('App\Models\Pharmacist\Prescription', 'patient_id');
    }

    public function surpres()
    {
        return $this->hasMany('App\Models\Pharmacist\SurgeryPrescription', 'patient_id');
    }

    public function experiments()
    {
        return $this->hasMany('App\Models\LabModule\Experiment', 'patient_id');
    }

    public static function generateRecordNo()
    {
        // get count of today's record
        $counts = Patient::whereDate('created_at', \Carbon\Carbon::today())->count();

        $strRecordNo = date('ymd') . ($counts + 1);

        return (int) $strRecordNo;
    }
}
