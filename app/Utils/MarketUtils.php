<?php

namespace App\Utils;

/**
 * Created by PhpStorm.
 * User: lnacosta
 * Date: 2017.11.08.
 * Time: 21:59
 */

class MarketUtils
{

    public static function calculateSpread($askValue, $bidValue) {
        if ($askValue && $bidValue) {
            return 100 * ($askValue - $bidValue) / $askValue;
        } else {
            return 0;
        }
    }

    public static function calculateSpreadString($askValue, $bidValue) {
        return MarketUtils::convertToStringWithPercentAndDecimals(MarketUtils::calculateSpread($askValue, $bidValue), 1);
    }

    public static function calculateChange($prevDay, $last) {
        if($prevDay){
            return ($last - $prevDay) / $prevDay * 100;
        }else {
            return 0;
        }
    }

    public static function calculateChangeString($prevDay, $last) {
        return MarketUtils::convertToStringWithPercentAndDecimals(MarketUtils::calculateChange($prevDay, $last), 1);
    }

    public static function convertToStringWithPercentAndDecimals($value, $decimals) {
        $valueString = "";
        $valueString .= number_format($value, $decimals);
        $valueString .= "%";
        return $valueString;
    }
}