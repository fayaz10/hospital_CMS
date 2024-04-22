<?php
/**
 * User: asifgulistani
 * Date: 3/25/2019
 * Time: 10:13 PM
 */

namespace App\iSys\Services;

class IncomeFormatter
{

    public static function toPercentage($total, $amount)
    {
        return ($amount * 100) / $total;
    }

    public static function toAmount($amount, $percent)
    {
        return ($amount * $percent) / 100;
    }

    public static function roundUpByTen($value)
    {
        return round($value, -1);
    }

    public static function roundUp($value, $roundUpper = 10)
    {
        if (!$roundUpper)
            throw new \App\Exceptions\CustomException('The Round upper not defined.');

        return round($value / $roundUpper) * $roundUpper;
    }

}