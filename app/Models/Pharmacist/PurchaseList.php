<?php

namespace App\Models\Pharmacist;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PurchaseList extends Model
{
    use LogsActivity;
    
    protected $table = 'purchased_medicines';

    protected $fillable = [
        'purchase_id',
        'medicine_id',
        'quantity',
        'benefits',
        'total_price',
        'currency_id',
    ];
    protected $casts = [
        'quantity' => 'float',
        'total_price' => 'float',
        'benefits' => 'float',
    ];


    protected static $logAttributes = ['*'];

    protected static $logName = 'MedicinePurchase\'s Logs';

    public function medicine()
    {
        return $this->belongsTo('App\Models\Pharmacist\Medicine', 'medicine_id');
    }

    public function purchase()
    {
        return $this->belongsTo('App\Models\Pharmacist\MedicinePuchase', 'purchase_id');
    }

    public function registrar()
    {
        return $this->belongsTo('App\User', 'registrar_id');
    }

    public function currency()
    {
        return $this->belongsTo('App\Models\FinanceModule\Currency', 'currency_id');
    }

    public function unit()
    {
        return $this->belongsTo('App\Models\Pharmacist\Unit', 'unit_id');
    }
}
