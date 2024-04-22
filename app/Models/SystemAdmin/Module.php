<?php

namespace App\Models\SystemAdmin;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Module extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['*'];

    protected static $logName = 'Module\'s Logs';

    protected $fillable = [
        'module_code', 'name_en', 'name_dr', 'name_pa', 'path', 'user_id'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }

    public function subModules()
    {
        return $this->hasMany(SubModule::class);
    }

    public function roles()
    {
        return $this->hasMany(Role::class);
    }

	public function permissions()
    {
        return $this->hasMany(Permission::class);
    }

}
