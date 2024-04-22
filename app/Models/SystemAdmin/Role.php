<?php

namespace App\Models\SystemAdmin;

use App\User;
use Zizaco\Entrust\EntrustRole;
use Spatie\Activitylog\Traits\LogsActivity;

class Role extends EntrustRole
{
    use LogsActivity;

    public $timestamps = false;

    protected static $logAttributes = ['*'];

    protected static $logName = 'Role\'s Logs';

    protected $fillable = [
        'name', 'label_en', 'label_dr', 'label_pa', 'desc_en', 'desc_dr', 'desc_pa', 'module_id'
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
