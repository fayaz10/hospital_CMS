<?php

namespace App\Models\FinanceModule;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiverseIncome extends Model
{
    use LogsActivity;
    use Searchable;
    use SoftDeletes;

    protected $table = "diverse_incomes";

    protected $fillable = [
        'category_id',
        'subject',
        'type',
        'registrar_id',
        'description',
        'patient_id',
        'dossier_no',
        'doctor_id',
        'discount',
        'membership_id',
    ];

    protected static $logAttributes = ['*'];

    protected static $logName = 'Diverse income\'s Logs';

    /**
     * Get the Fees's profitable.
     */
    public function profit()
    {
        return $this->morphOne('App\Models\FinanceModule\Income', 'profitable');
    }

    public function registrar()
    {
        return $this->belongsTo('App\User', 'registrar_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\FinanceModule\DiverseCategory', 'category_id');
    }

    public function attachments()
    {
        return $this->morphMany('App\Attachment', 'attachable');
    }
    
    public function patient()
    {
        return $this->belongsTo('App\Models\Receptionist\Patient', 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo('App\Models\Receptionist\Doctor', 'doctor_id');
    }
    
    public function getEnumValues($field, $table = null)
    {

        $tableName = $table ? $table : $this->table;

        $type = \DB::select(\DB::raw('SHOW COLUMNS FROM '. $tableName .' WHERE Field = "' . $field . '"'))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $values = array();
        foreach(explode(',', $matches[1]) as $value){
            $values[] = trim($value, "'");
        }
        return $values;
    }

    public static function getTypeValues()
    {
        return (new self)->getEnumValues('type');
    }
}
