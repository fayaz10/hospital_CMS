<?php

namespace App\Models\FinanceModule;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = "payment_methods";

    protected $fillable = [
        'type', 'label_en', 'label_dr'
    ];

}
