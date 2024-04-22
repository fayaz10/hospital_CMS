<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrintLog extends Model
{
    protected $table = 'print_logs';

    protected $fillable = [
        'printed_user', 'printable_id', 'printable_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'printed_user');
    }
}
