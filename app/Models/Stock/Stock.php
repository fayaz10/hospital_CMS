<?php

namespace App\Models\Stock;

use App\Exceptions\CustomException;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Stock extends Model
{
     use LogsActivity;

    protected $table = 'stock';

    protected $fillable = [
        'quantity',
        'unit_price',
        'currency_id',
    ];

    protected static $logAttributes = ['*'];

    protected static $logName = 'Stock\'s Logs';

    public function storable()
    {
        return $this->morphTo();
    }

    public function currency()
    {
        return $this->belongsTo('App\Models\FinanceModule\Currency', 'currency_id');
    }

    public function setQuantityAttribute($value)
    {
        if ($value < 0) throw new CustomException('Item out of stock.');

        $this->attributes['quantity'] = $value;
    }

    public function setUnitPriceAttribute($value)
    {
        if ($value < 0) throw new CustomException('Price can not set to zero or lower.');

        $this->attributes['unit_price'] = $value;
    }
}
