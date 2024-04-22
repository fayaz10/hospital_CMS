<?php

namespace App\Models\FinanceModule;

use App\Attachment;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Income extends Model
{
    use LogsActivity;
    use SoftDeletes;

    protected $table = "incomes";

    protected $appends = ['taxes', 'name', 'totalAmount', 'url'];

    protected $fillable = [
        'profitable_id',
        'profitable_type',
        'payment_date',
        'amount',
        'recipient',
        'currency_id',
        'tax',
        'payment_method_id',
        'registrar_id',
        'is_approved',
        'approved_user',
        'is_countable_tax',
    ];

    protected $casts = [
        'amount' => 'float',
        'is_approved' => 'boolean',
        'is_countable_tax' => 'boolean',
    ];

    /**
     * Get all of profit models.
     */

    protected static $logAttributes = ['*'];

    protected static $logName = 'Income\'s Logs';

    public function profitable()
    {
        return $this->morphTo();
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function registrar()
    {
        return $this->belongsTo(User::class, 'registrar_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_user');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function getTaxesAttribute()
    {
        if ($this->tax)
            return round(\App\iSys\Services\IncomeFormatter::toAmount($this->amount, $this->tax), 2);

        return null;
    }

    public function getTotalAmountAttribute()
    {
        if ($this->tax && $this->is_countable_tax == 0)
            return $this->amount;
            
        return round(round($this->amount + $this->taxes), -1);
    }

    public function getNameAttribute()
    {
        return __('finance.' . strtolower(basename($this->profitable_type, '\\')));
    }

    public function getUrlAttribute()
    {
        return \App\iSys\Services\UrlHelper::route(
            strtolower(basename($this->profitable_type, '\\')),
            [$this->profitable_id]
        );
    }

    public function getFillable()
    {
        return $this->fillable;
    }

    /**
     * Set the tax field.
     *
     * @param  string  $value
     * @return void
     */
    // public function setTaxAttribute($value)
    // {
    //     if ($value < 0 && $value > 100)
    //         throw new \App\Exceptions\CustomException("Wrong input for taxes, it between 0 to 100. but you entered {$value}.");

    //     $this->attributes['tax'] = $value;
    // }

    public function refundNotes()
    {
        return $this->morphMany('App\Models\Receptionist\RefundNote', 'source');
    }

}
