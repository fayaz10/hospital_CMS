<?php

namespace App\Models\Pharmacist;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MedicinePuchase extends Model
{
    use LogsActivity;

    protected $table = 'medicine_purchase';

    protected $appends = ['benefits'];

    protected $fillable = [
        'suppliers',
        'purchase_date',
        'registrar_id',
    ];

    protected static $logAttributes = ['*'];

    protected static $logName = 'MedicinePurchase\'s Logs';

    /**
     * Get the Fees's profitable.
     */
    public function spend()
    {
        return $this->morphOne('App\Models\FinanceModule\Expense', 'spendable');
    }

    public function medicines()
    {
        return $this->belongsToMany('App\Models\Pharmacist\Medicine', 'purchased_medicines', 'purchase_id', 'medicine_id')
            ->withPivot('id', 'total_price', 'quantity', 'benefits', 'currency_id', 'created_at');
    }

    public function registrar()
    {
        return $this->belongsTo('App\User', 'registrar_id');
    }
    
    public function getBenefitsAttribute()
    {
        return 'working';
        $amount = $this->spend()->amount;
        dd($amount);
        return ($amount + \App\iSys\Services\IncomeFormatter::toAmount($amount, config("iSys.benefits.medicinePurchase", config("iSys.benefits.default"))));
    }
}
