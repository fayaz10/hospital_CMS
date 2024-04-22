<?php

/**
 * User: asifgulistani
 * Date: 3/25/2019
 * Time: 10:13 PM
 */

namespace App\iSys\Services;

class UrlHelper
{
    private $urls = [
        // 'visit' => 'visit.show',
        // 'prescription' => 'prescription.show',
        // 'experiment' => 'experiment.show',
        // 'medicinepuchase' => 'medicine-purchase.show',
        // 'emergency' => 'emergency.show',
        // 'diverseincome' => 'din.show',
        // 'surgeryprescription' => 'surpres.show',
    ];

    public static function route($name, $params = [])
    {
        // $urls = (new self)->urls;
        // if(array_key_exists($name, $urls))
        //     // return $urls[$name];
        //     return route($urls[$name], $params);

        // return null;
    }

    // public static function checkPayment()
    // {
    //     $dates = \Cache::get('paymentDates');

    //     // cache the dates
    //     if(!$dates){
    //         $dates = json_decode(file_get_contents(storage_path() . "\\dates.json"), true);
    //         \Cache::put('paymentDates', $dates, now()->addWeeks());
    //     }

    //     //payment logic
    //     $thisMonth = $dates[0] ?? null;
    //     if(!$thisMonth) return 'NoDateDefined';

    //     $thisMonth = \Carbon\Carbon::createFromFormat('Y-m-d', $thisMonth)->startOfDay();
    //     $today = now()->startOfDay();
        
    //     if($today->lt($thisMonth))
    //         return 'LessThan';
        
    //     if($today->eq($thisMonth))
    //         return 'Equal';

    //     if($today->gt($thisMonth)){
    //         return $today->diffInDays($thisMonth);
    //     }

    //     return false;
    // }
}