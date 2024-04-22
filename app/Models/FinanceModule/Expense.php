<?php

namespace App\Models\FinanceModule;

use Illuminate\Database\Eloquent\Model;
use App\Attachment;
use App\User;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use LogsActivity;
    use SoftDeletes;

    protected $table = "expenses";

    protected $appends = ['name', 'url'];

    protected $fillable = [
        'spendable_id', 
        'spendable_type', 
        'payment_date', 
        'amount', 
        'remitter', 
        'currency_id',
        'remitter',
        'registrar_id',
        'approved_user'
    ];
    
    protected $casts = [
        'amount' => 'float',
    ];


    protected static $logAttributes = ['*'];

    protected static $logName = 'Expense\'s Logs';

    public function spendable()
    {
        return $this->morphTo();
    }
    
    public function currency()
    {
        return $this->belongsTo('App\Models\FinanceModule\Currency', 'currency_id');
    }

    public function registrar()
    {
        return $this->belongsTo('App\User', 'registrar_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_user');
    }

    public function attachments()
    {
        return $this->morphMany('App\Attachment', 'attachable');
    }
    
    public function getNameAttribute()
    {
        return __('finance.'.strtolower(basename($this->spendable_type, '\\')));
    }

    public function getUrlAttribute()
    {
        return \App\iSys\Services\UrlHelper::route(
            strtolower(basename($this->spendable_type, '\\')),
            [$this->spendable_id]
        );
    }

}
