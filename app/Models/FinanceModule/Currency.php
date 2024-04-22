<?php

namespace App\Models\FinanceModule;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = "currency";

    protected $fillable = [
        'name', 'symbol', 'label_en', 'label_dr'
    ];

}
