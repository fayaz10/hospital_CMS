<?php

namespace App\Models\LabModule;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Laravel\Scout\Searchable;

class SubTest extends Model
{
    use LogsActivity;
    use Searchable;

    protected $table = 'sub_tests';

    protected $fillable = [
        'name',
        'range',
    ];

    protected static $logAttributes = ['*'];

    protected static $logName = 'SubTest\'s Logs';

    public function tests()
    {
        return $this->belongsToMany('App\Models\LabModule\Test', 'tests_sub_tests', 'sub_test_id', 'test_id');
    }
}
