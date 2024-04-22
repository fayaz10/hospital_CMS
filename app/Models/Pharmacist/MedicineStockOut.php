<?php

namespace App\Models\Pharmacist;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MedicineStockOut extends Model
{
    use LogsActivity;

    protected $table = 'medicine_stockout';

    protected $fillable = [
        'prescription_id',
        'medicine_id',
        'quantity',
        'unit_price',
        'currency_id',
        'registrar_id',
    ];

    protected $casts = [
        'quantity' => 'float',
        'unit_price' => 'float',
    ];

    protected static $logAttributes = ['*'];

    protected static $logName = 'MedicineStockOut\'s Logs';

    public function medicine()
    {
        return $this->belongsTo('App\Models\Pharmacist\Medicine', 'medicine_id');
    }

    public function prescription()
    {
        return $this->belongsTo('App\Models\Pharmacist\Prescription', 'prescription_id');
    }
    
    public function registrar()
    {
        return $this->belongsTo('App\User', 'registrar_id');
    }

    public function currency()
    {
        return $this->belongsTo('App\Models\FinanceModule\Currency', 'currency_id');
    }
}
