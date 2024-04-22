<?php

namespace App\Models\LabModule;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Laravel\Scout\Searchable;

class Experiment extends Model
{
    use LogsActivity;
    use SoftDeletes;
    use Searchable;

    protected $table = 'experiments';

    protected $fillable = [
        'record_no',
        'patient_id',
        'doctor_id',
        'registrar_id',
        'status',
        'is_approved',
        'discount',
        'membership_id',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    protected static $logAttributes = ['*'];

    protected static $logName = 'Experiment\'s Logs';

    public function registrar()
    {
        return $this->belongsTo('App\User', 'registrar_id');
    }

    public function attachments()
    {
        return $this->morphMany('App\Attachment', 'attachable');
    }

    public function patient()
    {
        return $this->belongsTo('App\Models\Receptionist\Patient', 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo('App\Models\Receptionist\Doctor', 'doctor_id');
    }

    public function currency()
    {
        return $this->belongsTo('App\Models\FinanceModule\Currency', 'currency_id');
    }

    public function tests()
    {
        return $this->belongsToMany('App\Models\LabModule\Test', 'experiment_test')
            ->withPivot([
                'id',
                'price',
                'results',
                'description',
                'currency_id',
                'experimentor',
                'created_at'
            ]);
    }

    public function profit()
    {
        return $this->morphOne('App\Models\FinanceModule\Income', 'profitable');
    }

    public function approve()
    {
        return $this->morphMany('App\Approvable', 'approvable');
    }

    public static function generateRecordNo()
    {
        // get count of today's record
        $counts = Experiment::whereDate(
            'created_at', 
            '>=',
            \Carbon\Carbon::now()->startOfYear()->format('Y-m-d H:i:s')
        )->withTrashed()
        ->count();

        $strRecordNo = date('y') . ($counts + 1);

        return (int) $strRecordNo;
    }
}
