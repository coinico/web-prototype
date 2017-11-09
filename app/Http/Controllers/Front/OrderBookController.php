<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Utils\MarketUtils;
use Illuminate\Support\Facades\DB;
use App\Models\CryptoCurrency;
use App\Models\OrderBook;

/**
 * Class OrderBookController.
 *
 * @author lnacosta
 */
class OrderBookController extends Controller
{

    public function ctfMarkets()
    {
        $dbResults = DB::select("
                    select crypto_currency_to as crypto_currency, 
                           sum(quantity*value) as volume, 
                           max(value) as high, 
                           min(value) as low
                      from order_book 
                     where crypto_currency_from = 2 
                       and executed = 1
                       and updated_at >= (NOW() - INTERVAL 1 DAY) 
                  group by crypto_currency_to 
                  order by sum(quantity*value)");

        $ctfCurrency = CryptoCurrency::find(2);

        $result = array();

        foreach ($dbResults as $dbResult) {

            $currentCurrency = CryptoCurrency::find($dbResult->crypto_currency);

            $ask = OrderBook::where("crypto_currency_to", $dbResult->crypto_currency)
                ->where("executed", 0)
                ->where("type", "ask")
                ->orderBy('id', 'DESC')->first();

            $bid = OrderBook::where("crypto_currency_to", $dbResult->crypto_currency)
                ->where("executed", 0)
                ->where("type", "bid")
                ->orderBy('id', 'DESC')->first();

            $last = OrderBook::where("crypto_currency_to", $dbResult->crypto_currency)
                ->where("executed", 1)
                ->orderBy('id', 'DESC')->first();

            $prevDay = OrderBook::where("executed", 1)
                ->where("crypto_currency_to", $dbResult->crypto_currency)
                ->whereRaw('Date(updated_at) = CURDATE() -INTERVAL 1 DAY')
                ->orderBy('updated_at', 'DESC')->first();

            $spreadString = MarketUtils::calculateSpreadString($ask->value, $bid->value);

            if ($prevDay)
                $changeString = MarketUtils::calculateChangeString($prevDay->value, $last->value);
            else
                $changeString = "0.0%";

            $result[] = array(
                $ctfCurrency->alias."-".$currentCurrency->alias, //Market
                $currentCurrency->name, //Currency
                number_format($dbResult->volume, 3, '.', ''), //Volume
                $changeString,  //Change
                number_format($last->value, 8, '.', ''), //Last price
                number_format($dbResult->high, 8, '.', ''), //High
                number_format($dbResult->low, 8, '.', ''), //Low
                $spreadString  //Spread
            );
        };

        return $result;
    }
}
