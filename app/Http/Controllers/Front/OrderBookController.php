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

        $volumeCurrencies = DB::select("
                    select ob.crypto_currency_to as crypto_currency, 
                           sum(ob.quantity*ob.value) as volume, 
                           max(ob.value) as high, 
                           min(ob.value) as low,
                           cc.name as crypto_currency_name, 
                           cc.image as image, 
                           cc.alias as alias,
                           (select value from order_book where crypto_currency_to = ob.crypto_currency_to and 
            Date(updated_at) = CURDATE() -INTERVAL 1 DAY order by updated_at desc limit 1) as prev_day,
                           (select value from order_book where crypto_currency_to = ob.crypto_currency_to 
                            order by updated_at desc limit 1) as last_value,
                           (select (IF(isnull(prev_day), 0, (last_value - prev_day) / prev_day * 100))) as change_percent,
                           (select concat(FORMAT(change_percent, 1),'%')) as change_string
                      from order_book ob 
                inner join crypto_currencies cc
                        on cc.id = ob.crypto_currency_to
                     where ob.crypto_currency_from = 2 
                       and ob.closed_time is not null
                       and ob.updated_at >= (NOW() - INTERVAL 1 DAY) 
                  group by ob.crypto_currency_to,
                           cc.name,
                           cc.image,
                           cc.alias
                  order by volume desc
                     limit 2");

        $biggestGainCurrencies = DB::select("
                    select ob.crypto_currency_to as crypto_currency, 
                           sum(ob.quantity*ob.value) as volume, 
                           max(ob.value) as high, 
                           min(ob.value) as low,
                           cc.image as image, 
                           cc.name as crypto_currency_name, 
                           cc.alias as alias,
                           (select value from order_book where crypto_currency_to = ob.crypto_currency_to and 
            Date(updated_at) = CURDATE() -INTERVAL 1 DAY order by updated_at desc limit 1) as prev_day,
                           (select value from order_book where crypto_currency_to = ob.crypto_currency_to 
                            order by updated_at desc limit 1) as last_value,
                           (select (IF(isnull(prev_day), 0, (last_value - prev_day) / prev_day * 100))) as change_percent,
                           (select concat(FORMAT(change_percent, 1),'%')) as change_string
                      from order_book ob 
                inner join crypto_currencies cc
                        on cc.id = ob.crypto_currency_to
                     where ob.crypto_currency_from = 2 
                       and ob.closed_time is not null
                       and ob.updated_at >= (NOW() - INTERVAL 1 DAY) 
                  group by ob.crypto_currency_to,
                           cc.name,
                           cc.image,
                           cc.alias
                  order by change_percent desc
                     limit 2");



        return view('front.exchange.index', compact('volumeCurrencies', 'biggestGainCurrencies'));
    }

    public function exchangeDetails()
    {
        $pairArray = preg_split("~-~", Input::get("pair"));

        $currencyFrom = CryptoCurrency::where("alias", $pairArray[0])->first();
        $currencyTo = CryptoCurrency::where("alias", $pairArray[1])->first();

        $basicDetails = DB::select("select ob.crypto_currency_to, sum(ob.quantity*ob.value) as volume, 
                           max(ob.value) as high, 
                           min(ob.value) as low,
                           (select value from order_book where crypto_currency_to = ob.crypto_currency_to 
                            order by updated_at desc limit 1) as last_value,
                            (select value from order_book where crypto_currency_from = 2 and crypto_currency_to = ob.crypto_currency_to and closed_time is null and type = 'ask'
                            order by value asc , created_at desc  limit 1) as ask,
                            (select value from order_book where crypto_currency_from = 2 and crypto_currency_to = ob.crypto_currency_to and closed_time is null and type = 'bid'
                            order by value desc , created_at desc limit 1) as bid
                      from order_book ob 
                     where ob.crypto_currency_from = $currencyFrom->id
    and ob.crypto_currency_to = $currencyTo->id
    and ob.closed_time is not null
    and ob.updated_at >= (NOW() - INTERVAL 1 DAY) group by ob.crypto_currency_to")[0];

        return view('front.exchange.details', compact("currencyFrom", "currencyTo", 'basicDetails'));
    }

    public function lastExecutedOrders()
    {
        $dbResults = OrderBook::where("crypto_currency_from", Input::get("currencyFrom"))
            ->where("crypto_currency_to", Input::get("currencyTo"))
            ->whereNotNull("closed_time")
            ->orderBy("updated_at", "DESC")->get();

        $result = array();

        foreach ($dbResults as $dbResult) {

            $result[] = array(
                $dbResult->closed_time->format('d/m/Y H:i:s A'), //Market
                $dbResult->execution_type, //Currency
                number_format($dbResult->value, 8, '.', ''),
                number_format($dbResult->quantity, 8, '.', ''),
                number_format($dbResult->value * $dbResult->quantity, 8, '.', '')
            );
        }
        return $result;
    }

    public function myLastExecutedOrders()
    {
        $userId = auth()->user()->id;

        $dbResults = OrderBook::where("crypto_currency_from", Input::get("currencyFrom"))
            ->where("crypto_currency_to", Input::get("currencyTo"))
            ->whereNull("closed_time")
            ->where("user_id", $userId)
            ->orderBy("closed_time", "DESC")->get();

        $result = array();

        foreach ($dbResults as $dbResult) {

            $result[] = array(
                $dbResult->closed_time->format('d/m/Y H:i:s A'), //Market
                $dbResult->created_at->format('d/m/Y H:i:s A'), //Market
                $dbResult->execution_type, //Currency
                number_format($dbResult->value, 8, '.', ''),
                number_format($dbResult->quantity, 8, '.', ''),
                number_format($dbResult->value * $dbResult->quantity, 8, '.', '')
            );
        }
        return $result;
    }

    public function askOrders()
    {
        $dbResults = OrderBook::where("crypto_currency_from", Input::get("currencyFrom"))
            ->where("crypto_currency_to", Input::get("currencyTo"))
            ->whereNull("closed_time")
            ->where("type", "ask")
            ->orderBy("value", "ASC")
            ->orderBy("created_at", "DESC")->get();

        $result = array();
        $totalSum = 0;

        foreach ($dbResults as $dbResult) {

            $total = $dbResult->quantity * $dbResult->value;
            $sum = $totalSum + $total;
            $totalSum += $total;

            $result[] = array(
                number_format($dbResult->value, 8, '.', ''),
                number_format($dbResult->quantity, 8, '.', ''),
                number_format($total, 4, '.', ''),
                number_format($sum, 4, '.', '')
            );
        }
        return $result;
    }

    public function bidOrders()
    {
        $dbResults = OrderBook::where("crypto_currency_from", Input::get("currencyFrom"))
            ->where("crypto_currency_to", Input::get("currencyTo"))
            ->whereNull("closed_time")
            ->where("type", "bid")
            ->orderBy("value", "DESC")
            ->orderBy("created_at", "DESC")->get();

        $result = array();
        $totalSum = 0;

        foreach ($dbResults as $dbResult) {

            $total = $dbResult->quantity * $dbResult->value;
            $sum = $totalSum + $total;
            $totalSum += $total;

            $result[] = array(
                number_format($sum, 4, '.', ''),
                number_format($total, 4, '.', ''),
                number_format($dbResult->quantity, 8, '.', ''),
                number_format($dbResult->value, 8, '.', ''),
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
                           min(value) as low,
                           (select value from order_book where crypto_currency_to = ob.crypto_currency_to and 
            Date(updated_at) = CURDATE() -INTERVAL 1 DAY order by updated_at desc limit 1) as prev_day,
                           (select value from order_book where crypto_currency_to = ob.crypto_currency_to 
                            order by updated_at desc limit 1) as last_value,
                            (select value from order_book where crypto_currency_from = 2 and crypto_currency_to = ob.crypto_currency_to and closed_time is null and type = 'ask'
                            order by value asc , created_at desc  limit 1) as ask,
                            (select value from order_book where crypto_currency_from = 2 and crypto_currency_to = ob.crypto_currency_to and closed_time is null and type = 'bid'
                            order by value desc , created_at desc limit 1) as bid,
                           (select (IF(isnull(prev_day), 0, (last_value - prev_day) / prev_day * 100))) as change_percent,
                           (select concat(FORMAT(change_percent, 1),'%')) as change_string
                      from order_book ob
                     where crypto_currency_from = 2 
                       and closed_time is not null
                       and updated_at >= (NOW() - INTERVAL 1 DAY) 
                  group by crypto_currency_to 
                  order by sum(quantity*value) desc");

        $ctfCurrency = CryptoCurrency::find(2);

        $result = array();

        foreach ($dbResults as $dbResult) {

            $currentCurrency = CryptoCurrency::find($dbResult->crypto_currency);

            $spreadString = MarketUtils::calculateSpreadString($dbResult->ask, $dbResult->bid);

            $result[] = array(
                $ctfCurrency->alias."-".$currentCurrency->alias, //Market
                $currentCurrency->name, //Currency
                number_format($dbResult->volume, 3, '.', ''), //Volume
                $dbResult->change_string,  //Change
                number_format($dbResult->last_value, 8, '.', ''), //Last price
                number_format($dbResult->high, 8, '.', ''), //High
                number_format($dbResult->low, 8, '.', ''), //Low
                $spreadString  //Spread
            );
        };

        return $result;
    }
}
