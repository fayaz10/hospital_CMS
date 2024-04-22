<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Laravel\Scout\Searchable;

class Approvable extends Model
{
    use LogsActivity;
    use SoftDeletes;
    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'record_no', 
        'approvable_id', 
        'approvable_type', 
        'amount', 
        'currency_id', 
        'is_approved', 
        'approved_user', 
        'approved_date', 
        'type',
        'state'
    ];

    protected static $logAttributes = ['*'];

    protected static $logName = 'Approvale\'s Logs';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'state' => 'array',
    ];

    public function approvable()
    {
        return $this->morphTo();
    }

    public function approvedBy()
    {
        return $this->belongsTo('App\User', 'approved_user');
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
             'id' => $this->id,
             'record_no' => $this->record_no,
             'amount' => $this->amount,
             'is_approved' => $this->is_approved
        ];
    }
}
