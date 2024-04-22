<?php

namespace App\Models\Pharmacist;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Laravel\Scout\Searchable;

class Medicine extends Model
{
    use LogsActivity;
    use Searchable;
    
    protected $table = 'medicines';

    protected $fillable = [
        'name',
        'milligram',
        'company',
        'type_id',
        'unit_id',
        'expire_date'
    ];

    protected static $logAttributes = ['*'];

    protected static $logName = 'Medicine\'s Logs';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'expire_date' => 'datetime:Y-m-d',
    ];

    /**
     * Get the Fees's profitable.
     */
    public function store()
    {
        return $this->morphOne('App\Models\Stock\Stock', 'storable');
    }

    public function unit()
    {
        return $this->belongsTo('App\Models\Pharmacist\Unit', 'unit_id');
    }
    
    public function type()
    {
        return $this->belongsTo('App\Models\Pharmacist\MedicineType', 'type_id');
    }

    public function purchased($withPivot = false)
    {
        if($withPivot)
            return $this->belongsToMany('App\Models\Pharmacist\MedicinePuchase', 'purchased_medicines', 'medicine_id', 'purchase_id')
                ->withPivot('id', 'total_price', 'quantity', 'benefits', 'currency_id', 'created_at');

        return $this->belongsToMany('App\Models\Pharmacist\MedicinePuchase', 'purchased_medicines', 'medicine_id', 'purchase_id');
    }

}
