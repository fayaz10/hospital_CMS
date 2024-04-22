<?php

namespace App\Models\FinanceModule;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiverseExpense extends Model
{
    use LogsActivity;
    use Searchable;
    use SoftDeletes;

    protected $table = "diverse_expenses";

    protected $fillable = [
        'category_id',
        'reason',
        'type',
        'registrar_id',
        'description',
    ];

    protected static $logAttributes = ['*'];

    protected static $logName = 'Diverse expense\'s Logs';

    /**
     * Get the Fees's profitable.
     */
    public function spend()
    {
        return $this->morphOne('App\Models\FinanceModule\Expense', 'spendable');
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
