<?php

namespace App\Models\Pharmacist;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Unit extends Model
{
    use LogsActivity;
    
    protected $table = 'units';

    protected $fillable = [
        'name',
        'label_en',
        'label_dr'
    ];

    protected static $logAttributes = ['*'];

    protected static $logName = 'Unit\'s Logs';
}
