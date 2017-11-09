<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Utils\MarketUtils;
use Illuminate\Support\Facades\DB;
use App\Models\CryptoCurrency;
use App\Models\OrderBook;
use Illuminate\Support\Facades\Input;

/**
 * Class OrderBookController.
 *
 * @author lnacosta
 */
class OrderBookController extends Controller
{

    public function exchange()
    {
        return view('front.exchange.index');
    }

    public function exchangeDetails()
    {
        $pairArray = preg_split("~-~", Input::get("pair"));

        $currencyFrom = CryptoCurrency::where("alias", $pairArray[0])->first();
        $currencyTo = CryptoCurrency::where("alias", $pairArray[1])->first();

        return view('front.exchange.details', compact("currencyFrom", "currencyTo"));
    }

    public function lastExecutedOrders()
    {
        $dbResults = OrderBook::where("crypto_currency_from", Input::get("currencyFrom"))
            ->where("crypto_currency_to", Input::get("currencyTo"))
            ->where("executed", 1)
            ->orderBy("updated_at", "DESC")->get();

        $result = array();

        foreach ($dbResults as $dbResult) {

            $result[] = array(
                $dbResult->updated_at->format('Y/m/d - H:i:s'), //Market
                $dbResult->execution_type, //Currency
                number_format($dbResult->value, 8, '.', ''),
                number_format($dbResult->quantity, 8, '.', ''),
                number_format($dbResult->value * $dbResult->quantity, 8, '.', '')
            );
        }
        return $result;
    }

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
