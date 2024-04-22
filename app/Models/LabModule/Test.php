<?php

namespace App\Models\LabModule;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Laravel\Scout\Searchable;

class Test extends Model
{
    use LogsActivity;
    use Searchable;

    protected $table = 'tests';

    protected $fillable = [
        'name',
        'label_en',
        'label_dr',
        'description_en',
        'description_dr',
        'price',
        'currency_id',
        'duration',
    ];
    
    protected static $logAttributes = ['*'];

    protected static $logName = 'Test\'s Logs';

    public function registrar()
    {
        return $this->belongsTo('App\User', 'registrar_id');
    }
    
    public function attachments()
    {
        return $this->morphMany('App\Attachment', 'attachable');
    }

    public function currency()
    {
        return $this->belongsTo('App\Models\FinanceModule\Currency', 'currency_id');
    }

    public function experiments()
    {
        return $this->belongsToMany('App\Models\LabModule\Experiment', 'experiment_test');
    }

    public function subTests()
    {
        return $this->belongsToMany('App\Models\LabModule\SubTest', 'tests_sub_tests', 'test_id');
    }

}
