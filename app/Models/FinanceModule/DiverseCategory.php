<?php

namespace App\Models\FinanceModule;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class DiverseCategory extends Model
{
    use LogsActivity;
    protected $table = "diverse_category";

    protected $fillable = [
        'name',
        'label_en',
        'label_dr',
    ];
}
