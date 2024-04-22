<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Model;

class Fees extends Model
{
    protected $table = 'fees';

    /**
     * Get all of the owning contactable models.
     */
    public function payable()
    {
        return $this->morphTo();
    }

    public function currency()
    {
        return $this->belongsTo('App\Models\FinanceModule\Currency', 'currency_id');
    }
}
