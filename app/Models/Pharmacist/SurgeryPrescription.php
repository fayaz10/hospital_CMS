<?php

namespace App\Models\Pharmacist;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class SurgeryPrescription extends Model
{
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'surgery_prescriptions';

    protected $fillable = [
        'patient_id',
        'date',
        'registrar_id',
        'diagnosis',
        'is_approved',
    ];

    protected static $logAttributes = ['*'];

    protected static $logName = 'Surgery Prescription\'s Logs';

    public static function boot()
    {
        parent::boot();

        static::deleting(function($prescription) { // before delete() method call this
            $medicines = $prescription->medicines;
            foreach($medicines as $med){
                $store = $med->store;
                $store->quantity += $med->pivot->quantity;
                $store->save();
            }
        });
    }

    public function medicines()
    {
        return $this->belongsToMany('App\Models\Pharmacist\Medicine', 'surpres_medicine_stockout', 'prescription_id', 'medicine_id')
            ->withPivot('id', 'quantity', 'unit_price', 'currency_id', 'registrar_id', 'created_at');
    }

    /**
     * Get the Fees's profit.
     */
    public function profit()
    {
        return $this->morphOne('App\Models\FinanceModule\Income', 'profitable');
    }

    public function patient()
    {
        return $this->belongsTo('App\Models\Receptionist\Patient', 'patient_id');
    }

    public function approve()
    {
        return $this->morphMany('App\Approvable', 'approvable');
    }

    public function registrar()
    {
        return $this->belongsTo('App\User', 'registrar_id');
    }
}
