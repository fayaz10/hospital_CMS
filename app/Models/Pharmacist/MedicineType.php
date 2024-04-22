<?php

namespace App\Models\Pharmacist;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MedicineType extends Model
{
    use LogsActivity;
    
    protected $table = 'medicine_type';

    protected $fillable = [
        'name',
        'label_en',
        'label_dr'
    ];

    protected static $logAttributes = ['*'];

    protected static $logName = 'Medicine Type\'s Logs';
}
