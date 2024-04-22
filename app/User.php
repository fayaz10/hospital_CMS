<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;
    use LogsActivity;
    use Searchable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'name_dr', 
        'email', 
        'password', 
        'active', 
        'img_path', 
        'blocked_user_id', 
        'blocked_at', 
        'img_path', 
        'user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected static $logAttributes = ['*'];

    protected static $logName = 'User\'s Logs';

    public function roles()
    {
        return $this->belongsToMany(Models\SystemAdmin\Role::class);
    }

    public function modules()
    {
        return $this->belongsToMany(Models\SystemAdmin\Module::class);
    }

    public function registrar()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function restore()
    {
        $this->restoreA();
        $this->restoreB();
    }
}
