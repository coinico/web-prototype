<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\UserWallet;
use App\Utils\MarketUtils;
use Illuminate\Support\Facades\DB;
use App\Models\CryptoCurrency;
use App\Models\OrderBook;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use \Illuminate\Support\Facades\Auth;

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
                           (select value from order_book where crypto_currency_from = ob.crypto_currency_from and crypto_currency_to = ob.crypto_currency_to and closed_time is not null and
            Date(closed_time) = CURDATE() -INTERVAL 1 DAY order by closed_time desc limit 1) as prev_day, 
                           (select value from order_book where crypto_currency_from = ob.crypto_currency_from and crypto_currency_to = ob.crypto_currency_to  and closed_time is not null
                            order by closed_time desc limit 1) as last_value,
                           (select (IF(isnull(prev_day), 0, (last_value - prev_day) / prev_day * 100))) as change_percent,
                           (select concat(FORMAT(change_percent, 1),'%')) as change_string
                      from order_book ob 
                inner join crypto_currencies cc
                        on cc.id = ob.crypto_currency_to
                     where ob.closed_time is not null
                       and ob.closed_time >= (NOW() - INTERVAL 1 DAY) 
                  group by ob.crypto_currency_to,
                           ob.crypto_currency_from,
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
                           (select value from order_book where crypto_currency_from = ob.crypto_currency_from and crypto_currency_to = ob.crypto_currency_to and closed_time is not null and
            Date(closed_time) = CURDATE() -INTERVAL 1 DAY order by closed_time desc limit 1) as prev_day, 
                           (select value from order_book where crypto_currency_from = ob.crypto_currency_from and crypto_currency_to = ob.crypto_currency_to  and closed_time is not null
                            order by closed_time desc limit 1) as last_value,
                           (select (IF(isnull(prev_day), 0, (last_value - prev_day) / prev_day * 100))) as change_percent,
                           (select concat(FORMAT(change_percent, 1),'%')) as change_string
                      from order_book ob 
                inner join crypto_currencies cc
                        on cc.id = ob.crypto_currency_to
                     where ob.closed_time is not null
                       and ob.closed_time >= (NOW() - INTERVAL 1 DAY) 
                  group by ob.crypto_currency_to,
                           ob.crypto_currency_from,
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
                           (select value from order_book where crypto_currency_from = $currencyFrom->id and crypto_currency_to = ob.crypto_currency_to  and closed_time is not null
                            order by closed_time desc limit 1) as last_value,
                            (select value from order_book where crypto_currency_from = $currencyFrom->id and crypto_currency_to = ob.crypto_currency_to and closed_time is null and type = 'ask'
                            order by value asc , created_at desc  limit 1) as ask,
                            (select value from order_book where crypto_currency_from = $currencyFrom->id and crypto_currency_to = ob.crypto_currency_to and closed_time is null and type = 'bid'
                            order by value desc , created_at desc limit 1) as bid
                      from order_book ob 
                     where ob.crypto_currency_from = $currencyFrom->id
    and ob.crypto_currency_to = $currencyTo->id
    and ob.closed_time is not null
    and ob.closed_time >= (NOW() - INTERVAL 1 DAY) group by ob.crypto_currency_to")[0];

        $userLoggedIn = Auth::check();

        if ($userLoggedIn) {
            $walletFrom = UserWallet::where("user_id", auth()->user()->id)
                ->where("crypto_currency", $currencyFrom->id)->first();

            $walletTo = UserWallet::where("user_id", auth()->user()->id)
                ->where("crypto_currency", $currencyTo->id)->first();
        } else {
            $walletFrom = null;
            $walletTo = null;
        }

        return view('front.exchange.details', compact("currencyFrom", "currencyTo", 'basicDetails', 'userLoggedIn', 'walletFrom', 'walletTo'));
    }

    public function orders() {
        $userLoggedIn = Auth::check();
        return view('front.orders.index', compact( 'userLoggedIn'));
    }

    public function lastExecutedOrders()
    {
        $dbResults = OrderBook::where("crypto_currency_from", Input::get("currencyFrom"))
            ->where("crypto_currency_to", Input::get("currencyTo"))
            ->where('closed_time', '<>', '', 'and')
            ->orderBy("closed_time", "DESC")->get();

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
            ->where('closed_time', '<>', '', 'and')
            ->whereNotIn("filled", [0])
            ->where("user_id", $userId)
            ->orderBy("closed_time", "DESC")->get();

        $result = array();

        foreach ($dbResults as $dbResult) {

            $actualRate = $dbResult->current_cost/$dbResult->filled;
            $actualRate = $actualRate > 0 ? $actualRate : -$actualRate;

            $result[] = array(
                $dbResult->closed_time->format('d/m/Y H:i:s A'),
                $dbResult->created_at->format('d/m/Y H:i:s A'),
                "LIMIT ".strtoupper($dbResult->execution_type),
                number_format($dbResult->value, 8, '.', ''),
                number_format($dbResult->filled, 8, '.', ''),
                number_format($dbResult->quantity, 8, '.', ''),
                number_format($actualRate, 8, '.', ''),
                number_format($dbResult->current_cost, 8, '.', '')
            );
        }
        return $result;
    }

    public function allMyLastExecutedOrders()
    {
        $userId = auth()->user()->id;

        $dbResults = OrderBook::where("user_id", $userId)
            ->whereNotNull("closed_time")
            ->whereNotIn("filled", [0])
            ->orderBy("closed_time", "DESC")->get();

        $result = array();

        foreach ($dbResults as $dbResult) {

            $actualRate = $dbResult->current_cost/$dbResult->filled;
            $actualRate = $actualRate > 0 ? $actualRate : -$actualRate;

            $result[] = array(
                $dbResult->closed_time->format('d/m/Y H:i:s A'),
                $dbResult->created_at->format('d/m/Y H:i:s A'),
                $dbResult->cryptoCurrencyFrom->alias."-".$dbResult->cryptoCurrencyTo->alias,
                "LIMIT ".strtoupper($dbResult->execution_type),
                number_format($dbResult->value, 8, '.', ''),
                number_format($dbResult->filled, 8, '.', ''),
                number_format($dbResult->quantity, 8, '.', ''),
                number_format($actualRate, 8, '.', ''),
                number_format($dbResult->current_cost, 8, '.', '')
            );
        }
        return $result;
    }

    public function deleteOrder()
    {

        if (auth()->user() !== null) {
            $userId = auth()->user()->id;
        } else {
            $userId = null;
        }

        $order = OrderBook::find(Input::get("orderId"));

        $result = array();

        if ($order !== null) {
            if ($userId === $order->user_id) {

                if ($order->closed_time === null) {
                    $order->update(array('closed_time' => Carbon::now()->format('Y-m-d H:i:s')));
                    $result["message"] = "Orden cerrada con éxito.";
                    $result["type"] = "success";
                } else {
                    $result["message"] = "La orden ya se encuentra cerrada.";
                    $result["type"] = "error";
                }

            } else {
                $result["message"] = "El usuario no es dueño de la orden o no se encuentra logueado.";
                $result["type"] = "error";
            }
        } else {
            $result["message"] = "La orden indicada no existe.";
            $result["type"] = "error";
        }

        return $result;
    }

    public function myOpenOrders()
    {
        $userId = auth()->user()->id;

        $dbResults = OrderBook::where("crypto_currency_from", Input::get("currencyFrom"))
            ->where("crypto_currency_to", Input::get("currencyTo"))
            ->whereNull("closed_time")
            ->where("user_id", $userId)
            ->orderBy("created_at", "DESC")->get();

        $result = array();

        foreach ($dbResults as $dbResult) {

            if ($dbResult->filled > 0) {
                $actualRate = $dbResult->current_cost / $dbResult->filled;
                $actualRate = $actualRate > 0 ? $actualRate : -$actualRate;
            } else {
                $actualRate = 0;
            }

            $result[] = array(
                $dbResult->created_at->format('d/m/Y H:i:s A'),
                "LIMIT ".strtoupper($dbResult->execution_type),
                number_format($dbResult->value, 8, '.', ''),
                number_format($dbResult->filled, 8, '.', ''),
                number_format($dbResult->quantity, 8, '.', ''),
                number_format($actualRate, 8, '.', ''),
                number_format($dbResult->value*$dbResult->quantity, 8, '.', ''),
                $dbResult->id
            );
        }
        return $result;
    }

    public function allMyOpenOrders()
    {
        $userId = auth()->user()->id;

        $dbResults = OrderBook::where("user_id", $userId)
            ->whereNull("closed_time")
            ->orderBy("created_at", "DESC")->get();

        $result = array();

        foreach ($dbResults as $dbResult) {

            if ($dbResult->filled > 0) {
                $actualRate = $dbResult->current_cost / $dbResult->filled;
                $actualRate = $actualRate > 0 ? $actualRate : -$actualRate;
            } else {
                $actualRate = 0;
            }

            $result[] = array(
                $dbResult->created_at->format('d/m/Y H:i:s A'),
                $dbResult->cryptoCurrencyFrom->alias."-".$dbResult->cryptoCurrencyTo->alias,
                "LIMIT ".strtoupper($dbResult->execution_type),
                number_format($dbResult->value, 8, '.', ''),
                number_format($dbResult->filled, 8, '.', ''),
                number_format($dbResult->quantity, 8, '.', ''),
                number_format($actualRate, 8, '.', ''),
                number_format($dbResult->value*$dbResult->quantity, 8, '.', ''),
                $dbResult->id
            );
        }
        return $result;
    }

    public function askOrders()
    {
        $ccf = Input::get("currencyFrom");
        $cct = Input::get("currencyTo");

        $dbResults = DB::select("
          SELECT value, 
                 sum(quantity) as cantidad, 
                 value*sum(quantity)  as total
            from order_book 
           where crypto_currency_from = $ccf
             and crypto_currency_to = $cct
             and closed_time is null
             and type = 'ask'
           group by value
           order by value asc");

        $result = array();
        $totalSum = 0;

        foreach ($dbResults as $dbResult) {

            $totalSum += $dbResult->total;

            $result[] = array(
                number_format($dbResult->value, 8, '.', ''),
                number_format($dbResult->cantidad, 8, '.', ''),
                number_format($dbResult->total, 4, '.', ''),
                number_format($totalSum, 4, '.', '')
            );
        }
        return $result;
    }

    public function bidOrders()
    {
        $ccf = Input::get("currencyFrom");
        $cct = Input::get("currencyTo");

        $dbResults = DB::select("
          SELECT value, 
                 sum(quantity) as cantidad, 
                 value*sum(quantity)  as total
            from order_book 
           where crypto_currency_from = $ccf
             and crypto_currency_to = $cct
             and closed_time is null
             and type = 'bid'
           group by value
           order by value desc");

        $result = array();
        $totalSum = 0;

        foreach ($dbResults as $dbResult) {

            $totalSum += $dbResult->total;

            $result[] = array(
                number_format($totalSum, 4, '.', ''),
                number_format($dbResult->total, 4, '.', ''),
                number_format($dbResult->cantidad, 8, '.', ''),
                number_format($dbResult->value, 8, '.', ''),
            );
        }
        return $result;
    }

    public function ctfMarkets()
    {
        return $this->marketsInformation(2);
    }

    public function ethMarkets()
    {
        return $this->marketsInformation(1);
    }

    public function marketsInformation($cryptoCurrencyFrom)
    {

        $dbResults = DB::select("
                    select crypto_currency_to as crypto_currency, 
                           sum(quantity*value) as volume, 
                           max(value) as high, 
                           min(value) as low,
                           (select value from order_book where crypto_currency_from = $cryptoCurrencyFrom and crypto_currency_to = ob.crypto_currency_to and closed_time is not null and
            Date(closed_time) = CURDATE() -INTERVAL 1 DAY order by closed_time desc limit 1) as prev_day, 
                           (select value from order_book where crypto_currency_from = $cryptoCurrencyFrom and crypto_currency_to = ob.crypto_currency_to  and closed_time is not null
                            order by closed_time desc limit 1) as last_value,
                            (select value from order_book where crypto_currency_from = $cryptoCurrencyFrom and crypto_currency_to = ob.crypto_currency_to and closed_time is null and type = 'ask'
                            order by value asc , created_at desc  limit 1) as ask,
                            (select value from order_book where crypto_currency_from = $cryptoCurrencyFrom and crypto_currency_to = ob.crypto_currency_to and closed_time is null and type = 'bid'
                            order by value desc , created_at desc limit 1) as bid,
                           (select (IF(isnull(prev_day), 0, (last_value - prev_day) / prev_day * 100))) as change_percent,
                           (select concat(FORMAT(change_percent, 1),'%')) as change_string
                      from order_book ob
                     where crypto_currency_from = $cryptoCurrencyFrom 
                       and closed_time is not null
                       and closed_time >= (NOW() - INTERVAL 1 DAY) 
                  group by crypto_currency_to 
                  order by sum(quantity*value) desc");

        $ctfCurrency = CryptoCurrency::find($cryptoCurrencyFrom);

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
