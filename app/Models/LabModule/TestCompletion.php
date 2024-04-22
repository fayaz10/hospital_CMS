<?php

namespace App\Models\LabModule;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class TestCompletion extends Model
{
    use LogsActivity;
    
    protected $table = 'experiment_test';

    protected $fillable = [
        'test_id',
        'experiment_id',
        'results',
        'price',
        'description',
        'experimentor'
    ];

    
    protected static $logAttributes = ['*'];

    protected static $logName = 'TestCompletion\'s Logs';

    public function registrar()
    {
        return $this->belongsTo('App\User', 'registrar_id');
    }
    
    public function attachments()
    {
        return $this->morphMany('App\Attachment', 'attachable');
    }

    public function test()
    {
        return $this->belongsTo('App\Models\LabModule\Test', 'test_id');
    }

}
