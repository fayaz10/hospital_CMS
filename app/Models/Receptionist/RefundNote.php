<?php

namespace App\Models\Receptionist;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;

class RefundNote extends Model
{
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'refund_notes';

    protected $fillable = [
        'source_id',
        'source_type',
        'type',
        'ttl',
        'amount',
        'approved_user',
        'registrar_id',
    ];

    protected static $logAttributes = ['*'];

    protected static $logName = 'RefundNotes\'s Logs';

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::addGlobalScope('ttl', function (Builder $builder) {
    //         $builder->whereDate('ttl', '>=', date('Y-m-d H:i:s'));
    //     });
    // }

    public function source()
    {
        return $this->morphTo();
    }

    public function approvedUser()
    {
        return $this->belongsTo('App\User', 'approved_user');
    }
}
