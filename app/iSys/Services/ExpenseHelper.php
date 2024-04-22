<?php

/**
 * User: asifgulistani
 * Date: 3/25/2019
 * Time: 10:13 PM
 */

namespace App\iSys\Services;

class ExpenseHelper
{

    public static function unitPriceWithBenefits($totalAmount, $quantity)
    {
        //get the benefit percentage
        $benefit = config("iSys.benefits.medicinePurchase", config("iSys.benefits.default"));

        return round(self::withSpecificBenefits($totalAmount, $benefit) / $quantity, 1);
    }

    public static function withBenefits($totalAmount)
    {
        //get the benefit percentage
        $benefit = config("iSys.benefits.medicinePurchase", config("iSys.benefits.default"));

        return round(self::withSpecificBenefits($totalAmount, $benefit), -1);
    }

    public static function withSpecificBenefits($totalAmount, $benefitPercentage)
    {
        if (!$benefitPercentage)
            throw new \App\Exceptions\CustomException('The benefit percentage not defined.');

        if ($benefitPercentage <= 0 || $benefitPercentage >= 100)
            throw new \App\Exceptions\CustomException('The benefit percentage should be between 0.01 to 99.99.');
        
        return ($totalAmount + IncomeFormatter::toAmount($totalAmount, $benefitPercentage));
    }
}