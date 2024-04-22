<?php
namespace App\Models\SystemAdmin;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    public $timestamps = false;

    protected $fillable = [
        'name', 'label_en', 'label_dr', 'label_pa', 'description','module_id',
    ];

    public function roles()
    {
        return $this->belongsTo(Role::class);
    }
	public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
