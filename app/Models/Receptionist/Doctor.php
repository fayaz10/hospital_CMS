<?php

namespace App\Models\Receptionist;

use Illuminate\Database\Eloquent\Model;
use App\Attachment;
use App\User;
use Spatie\Activitylog\Traits\LogsActivity;
use Laravel\Scout\Searchable;

class Doctor extends Model
{
    use LogsActivity;
    use Searchable;

    protected $table = 'doctors';

    protected $appends = ['name'];

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'specialist',
        'visit_fee',
        'currency_id',
        'photo',
        'registrar_id',
    ];

    
    protected static $logAttributes = ['*'];

    protected static $logName = 'Doctor\'s Logs';

    public function registrar()
    {
        return $this->belongsTo(User::class, 'registrar_id');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function visits()
    {
        return $this->hasMany('App\Models\Receptionist\Visit', 'doctor_id');
    }

    public function currency()
    {
        return $this->belongsTo(\App\Models\FinanceModule\Currency::class, 'currency_id');
    }

    public function getNameAttribute()
    {
        return ucfirst($this->first_name . ' ' . $this->last_name);
    }
}
