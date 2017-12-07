<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\CryptoCurrency;
use App\Models\OrderBook;
use App\Models\UserWallet;
use App\Models\UserWalletTransaction;
use App\Utils\MarketUtils;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
                    select cf.alias as crypto_currency_from,
                           ob.crypto_currency_to as crypto_currency, 
                           sum(ob.quantity*ob.value) as volume, 
                           max(ob.value) as high, 
                           min(ob.value) as low,
                           cc.name as crypto_currency_name, 
                           cc.image as image, 
                           cc.alias as alias,
                           cc.type as typex,
                           (select value from order_book where crypto_currency_from = ob.crypto_currency_from and crypto_currency_to = ob.crypto_currency_to and closed_time is not null and
            Date(closed_time) = CURDATE() -INTERVAL 1 DAY order by closed_time desc limit 1) as prev_day, 
                           (select value from order_book where crypto_currency_from = ob.crypto_currency_from and crypto_currency_to = ob.crypto_currency_to  and closed_time is not null
                            order by closed_time desc limit 1) as last_value,
                           (select (IF(isnull(prev_day), 0, (last_value - prev_day) / prev_day * 100))) as change_percent,
                           (select concat(FORMAT(change_percent, 1),'%')) as change_string
                      from order_book ob 
                inner join crypto_currencies cc
                        on cc.id = ob.crypto_currency_to
                inner join crypto_currencies cf
                        on cf.id = ob.crypto_currency_from
                     where ob.closed_time is not null
                       and ob.closed_time >= (NOW() - INTERVAL 1 DAY) 
                  group by ob.crypto_currency_to,
                           ob.crypto_currency_from,
                           cc.name,
                           cc.image,
                           cc.alias,
                           cf.alias,
                           cc.type
                  order by volume desc
                     limit 2");

        $biggestGainCurrencies = DB::select("
                    select cf.alias as crypto_currency_from,
                           ob.crypto_currency_to as crypto_currency, 
                           sum(ob.quantity*ob.value) as volume, 
                           max(ob.value) as high, 
                           min(ob.value) as low,
                           cc.image as image, 
                           cc.name as crypto_currency_name, 
                           cc.alias as alias,
                           cc.type as typex,
                           (select value from order_book where crypto_currency_from = ob.crypto_currency_from and crypto_currency_to = ob.crypto_currency_to and closed_time is not null and
            Date(closed_time) = CURDATE() -INTERVAL 1 DAY order by closed_time desc limit 1) as prev_day, 
                           (select value from order_book where crypto_currency_from = ob.crypto_currency_from and crypto_currency_to = ob.crypto_currency_to  and closed_time is not null
                            order by closed_time desc limit 1) as last_value,
                           (select (IF(isnull(prev_day), 0, (last_value - prev_day) / prev_day * 100))) as change_percent,
                           (select concat(FORMAT(change_percent, 1),'%')) as change_string
                      from order_book ob 
                inner join crypto_currencies cc
                        on cc.id = ob.crypto_currency_to
                inner join crypto_currencies cf
                        on cf.id = ob.crypto_currency_from
                     where ob.closed_time is not null
                       and ob.closed_time >= (NOW() - INTERVAL 1 DAY) 
                  group by ob.crypto_currency_to,
                           ob.crypto_currency_from,
                           cc.name,
                           cc.image,
                           cc.alias,
                           cf.alias,
                           cc.type
                  order by change_percent desc
                     limit 2");

        return view('front.exchange.index', compact('volumeCurrencies', 'biggestGainCurrencies'));
    }

    public function exchangeDetails()
    {
        $pairArray = preg_split("~-~", Input::get("pair"));

        $currencyFrom = CryptoCurrency::where("alias", $pairArray[0])->first();
        $currencyTo = CryptoCurrency::where("alias", $pairArray[1])->first();

        $basicDetails1 = DB::select("select ob.crypto_currency_to, sum(ob.quantity*ob.value) as volume, 
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
    and ob.closed_time >= (NOW() - INTERVAL 1 DAY) group by ob.crypto_currency_to");

        if (count($basicDetails1)> 0)
            $basicDetails = $basicDetails1[0];
        else
            $basicDetails = null;

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
            ->orderBy("closed_time", "DESC")
            ->limit(50)->get();

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
        $dbResults = OrderBook::where("crypto_currency_from", Input::get("currencyFrom"))
            ->where("crypto_currency_to", Input::get("currencyTo"))
            ->where('closed_time', '<>', '', 'and')
            ->whereNotIn("filled", [0])
            ->where(function ($query) {
                $query
                    ->where("user_id", auth()->user()->id)
                    ->orWhere('user_id_2', auth()->user()->id);
            })
            ->orderBy("closed_time", "DESC")
            ->limit(50)->get();

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
            ->orderBy("closed_time", "DESC")
            ->limit(50)->get();

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
            ->orderBy("created_at", "DESC")
            ->limit(50)->get();

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
            ->orderBy("created_at", "DESC")
            ->limit(50)->get();

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

    public function createBidOrder() {
        $result = array();

        $userId = auth()->user()->id;
        $ccf = Input::get("currencyFrom");
        $cct = Input::get("currencyTo");

        $currencyFrom = CryptoCurrency::find($ccf);
        $currencyTo = CryptoCurrency::find($cct);

        $cantidad = floatval(Input::get("cantidad"));
        $precio = floatval(Input::get("precio"));
        $subtotal = floatval(Input::get("subtotal"));
        $comision = floatval(Input::get("comision"));
        $total = floatval(Input::get("total"));

        $walletFrom = UserWallet::where("user_id", $userId)->where("crypto_currency", $ccf)->first();
        $walletTo = UserWallet::where("user_id", $userId)->where("crypto_currency", $cct)->first();

        if (!$walletTo) {
            $walletTo = UserWallet::create(
                [
                    'user_id' => $userId,
                    'crypto_currency' => $cct,
                ]
            );
        }
        // si tengo el balance
        if (floatval($walletFrom->available_balance) > floatval($total)) {

            // si no hay ordenes de venta (contrarias) con valor menor al indicado,

            $cheaperOrder = OrderBook::whereNull("closed_time")
                ->where("type", "ask")
                ->where("crypto_currency_from", $ccf)
                ->where("crypto_currency_to", $cct)
                ->where("value", "<", $precio)
                ->orderBy("closed_time", "asc")->first();

            if (!$cheaperOrder) {

                $equalOrder = OrderBook::whereNull("closed_time")
                    ->where("type", "ask")
                    ->where("crypto_currency_from", $ccf)
                    ->where("crypto_currency_to", $cct)
                    ->where("value", "=", $precio)
                    ->where("quantity", "=", $cantidad)
                    ->orderBy("closed_time", "asc")->first();

                // si no hay ordenes iguales, creo la orden y la transacción hold
                if (!$equalOrder) {

                    $transactionCurrent = UserWalletTransaction::create(
                        [
                            'address_from' => '0xfe8f6b1a27625c2eadd2743ff963b16b1d931f61',
                            'address_to' => '0xfe8f6b1a27625c2eadd2743ff963b16b1d931f61',
                            'amount' => -$subtotal,
                            'type' => 'debit',
                            'is_hold' => 1,
                            'memo' => 'Hold en exchange.',
                            'transaction_hash' => '0x35f29841f9fe3747c0327c261019f22a08718e6650492a5ba01dc2a4b76efeb5',
                            'transaction_fee' => 0,
                            'total' => -$subtotal,
                            'user_wallet' => $walletFrom->id,
                        ]
                    );

                    OrderBook::create(
                        [
                            'user_id' => $userId,
                            'crypto_currency_from' => $currencyFrom->id,
                            'crypto_currency_to' => $currencyTo->id,
                            'type' => "bid",
                            'quantity' => $cantidad,
                            'value' => $precio,
                            'execution_type' => "buy",
                            "transaction_id" => $transactionCurrent->id
                        ]
                    );

                    $result["type"] = "success";
                    $result["message"] = "Orden creada con éxito.";
                } else {

                    $equalOrder->closed_time = \Carbon\Carbon::now()->subMinutes(rand(1, 17999))->format('Y-m-d H:i:s');
                    $equalOrder->filled = $equalOrder->quantity;
                    $equalOrder->current_cost = $equalOrder->quantity*$equalOrder->value;
                    $equalOrder->user_id_2 = $userId;

                    $equalOrder->save();

                    UserWalletTransaction::create(
                        [
                            'address_from' => '0xfe8f6b1a27625c2eadd2743ff963b16b1d931f61',
                            'address_to' => '0xfe8f6b1a27625c2eadd2743ff963b16b1d931f61',
                            'amount' => $cantidad,
                            'type' => 'credit',
                            'is_hold' => 0,
                            'memo' => 'Compra en exchange.',
                            'transaction_hash' => '0x35f29841f9fe3747c0327c261019f22a08718e6650492a5ba01dc2a4b76efeb5',
                            'transaction_fee' => 0,
                            'total' => $cantidad,
                            'user_wallet' => $walletTo->id,
                        ]
                    );

                    UserWalletTransaction::create(
                        [
                            'address_from' => '0xfe8f6b1a27625c2eadd2743ff963b16b1d931f61',
                            'address_to' => '0xfe8f6b1a27625c2eadd2743ff963b16b1d931f61',
                            'amount' => -$subtotal,
                            'type' => 'debit',
                            'is_hold' => 0,
                            'memo' => 'Venta en exchange.',
                            'transaction_hash' => '0x35f29841f9fe3747c0327c261019f22a08718e6650492a5ba01dc2a4b76efeb5',
                            'transaction_fee' => 0,
                            'total' => -$subtotal,
                            'user_wallet' => $walletFrom->id,
                        ]
                    );

                    $otherUserWalletFrom = UserWallet::where("user_id", $equalOrder->user_id)
                        ->where("crypto_currency", $ccf)->first();


                    UserWalletTransaction::create(
                        [
                            'address_from' => '0xfe8f6b1a27625c2eadd2743ff963b16b1d931f61',
                            'address_to' => '0xfe8f6b1a27625c2eadd2743ff963b16b1d931f61',
                            'amount' => $subtotal,
                            'type' => 'credit',
                            'is_hold' => 0,
                            'memo' => 'Venta en exchange.',
                            'transaction_hash' => '0x35f29841f9fe3747c0327c261019f22a08718e6650492a5ba01dc2a4b76efeb5',
                            'transaction_fee' => $subtotal,
                            'total' => $subtotal,
                            'user_wallet' => $otherUserWalletFrom->id,
                        ]
                    );

                    $transaction = UserWalletTransaction::find($equalOrder->transaction_id);

                    if($transaction) {
                        $transaction->is_hold = 0;
                        $equalOrder->save();
                    }

                    $result["type"] = "success";
                    $result["message"] = "Orden creada y ejecutada con éxito.";
                }
            } else {

                $result["type"] = "error";
                $result["message"] = "Existen órdenes con precios más bajos.";
            }

        } else {
            $result["type"] = "error";
            $result["message"] = "No posees fondos suficientes para realizar la operación.".floatval($walletFrom->available_balance)." asdasd ".floatval($total);
        }

        return $result;
    }

    public function createAskOrder() {
        $result = array();

        $userId = auth()->user()->id;
        $ccf = Input::get("currencyFrom");
        $cct = Input::get("currencyTo");

        $currencyFrom = CryptoCurrency::find($ccf);
        $currencyTo = CryptoCurrency::find($cct);

        $cantidad = floatval(Input::get("cantidad"));
        $precio = floatval(Input::get("precio"));
        $subtotal = floatval(Input::get("subtotal"));
        $comision = floatval(Input::get("comision"));
        $total = floatval(Input::get("total"));

        $walletFrom = UserWallet::where("user_id", $userId)->where("crypto_currency", $ccf)->first();
        $walletTo = UserWallet::where("user_id", $userId)->where("crypto_currency", $cct)->first();

        if (!$walletFrom) {
            $walletFrom = UserWallet::create(
                [
                    'user_id' => $userId,
                    'crypto_currency' => $ccf,
                ]
            );
        }
        // si tengo el balance
        if (floatval($walletTo->available_balance) > floatval($cantidad)) {

            // si no hay ordenes de venta (contrarias) con valor menor al indicado,

            $expensiveOrder = OrderBook::whereNull("closed_time")
                ->where("type", "bid")
                ->where("crypto_currency_from", $ccf)
                ->where("crypto_currency_to", $cct)
                ->where("value", ">", $precio)
                ->orderBy("closed_time", "asc")->first();

            if (!$expensiveOrder) {

                $equalOrder = OrderBook::whereNull("closed_time")
                    ->where("type", "bid")
                    ->where("crypto_currency_from", $ccf)
                    ->where("crypto_currency_to", $cct)
                    ->where("value", "=", $precio)
                    ->where("quantity", "=", $cantidad)
                    ->orderBy("closed_time", "asc")->first();

                // si no hay ordenes iguales, creo la orden y la transacción hold
                if (!$equalOrder) {

                    $transactionCurrent = UserWalletTransaction::create(
                        [
                            'address_from' => '0xfe8f6b1a27625c2eadd2743ff963b16b1d931f61',
                            'address_to' => '0xfe8f6b1a27625c2eadd2743ff963b16b1d931f61',
                            'amount' => -$cantidad,
                            'type' => 'debit',
                            'is_hold' => 1,
                            'memo' => 'Hold en exchange.',
                            'transaction_hash' => '0x35f29841f9fe3747c0327c261019f22a08718e6650492a5ba01dc2a4b76efeb5',
                            'transaction_fee' => 0,
                            'total' => -$cantidad,
                            'user_wallet' => $walletTo->id,
                        ]
                    );

                    OrderBook::create(
                        [
                            'user_id' => $userId,
                            'crypto_currency_from' => $currencyFrom->id,
                            'crypto_currency_to' => $currencyTo->id,
                            'type' => "ask",
                            'quantity' => $cantidad,
                            'value' => $precio,
                            'execution_type' => "sell",
                            "transaction_id" => $transactionCurrent->id
                        ]
                    );

                    $result["type"] = "success";
                    $result["message"] = "Orden creada con éxito.";
                } else {

                    $equalOrder->closed_time = \Carbon\Carbon::now()->subMinutes(rand(1, 17999))->format('Y-m-d H:i:s');
                    $equalOrder->filled = $equalOrder->quantity;
                    $equalOrder->current_cost = $equalOrder->quantity*$equalOrder->value;
                    $equalOrder->user_id_2 = $userId;

                    $equalOrder->save();

                    $otherUserWalletTo = UserWallet::where("user_id", $equalOrder->user_id)
                        ->where("crypto_currency", $cct)->first();

                    UserWalletTransaction::create(
                        [
                            'address_from' => '0xfe8f6b1a27625c2eadd2743ff963b16b1d931f61',
                            'address_to' => '0xfe8f6b1a27625c2eadd2743ff963b16b1d931f61',
                            'amount' => $cantidad,
                            'type' => 'credit',
                            'is_hold' => 0,
                            'memo' => 'Venta en exchange.',
                            'transaction_hash' => '0x35f29841f9fe3747c0327c261019f22a08718e6650492a5ba01dc2a4b76efeb5',
                            'transaction_fee' => 0,
                            'total' => $cantidad,
                            'user_wallet' => $otherUserWalletTo->id,
                        ]
                    );

                    UserWalletTransaction::create(
                        [
                            'address_from' => '0xfe8f6b1a27625c2eadd2743ff963b16b1d931f61',
                            'address_to' => '0xfe8f6b1a27625c2eadd2743ff963b16b1d931f61',
                            'amount' => -$cantidad,
                            'type' => 'debit',
                            'is_hold' => 0,
                            'memo' => 'Venta en exchange.',
                            'transaction_hash' => '0x35f29841f9fe3747c0327c261019f22a08718e6650492a5ba01dc2a4b76efeb5',
                            'transaction_fee' => 0,
                            'total' => -$cantidad,
                            'user_wallet' => $walletTo->id,
                        ]
                    );


                    UserWalletTransaction::create(
                        [
                            'address_from' => '0xfe8f6b1a27625c2eadd2743ff963b16b1d931f61',
                            'address_to' => '0xfe8f6b1a27625c2eadd2743ff963b16b1d931f61',
                            'amount' => $total,
                            'type' => 'credit',
                            'is_hold' => 0,
                            'memo' => 'Venta en exchange.',
                            'transaction_hash' => '0x35f29841f9fe3747c0327c261019f22a08718e6650492a5ba01dc2a4b76efeb5',
                            'transaction_fee' => $total,
                            'total' => $total,
                            'user_wallet' => $walletFrom->id,
                        ]
                    );

                    $transaction = UserWalletTransaction::find($equalOrder->transaction_id);

                    if($transaction) {
                        $transaction->is_hold = 0;
                        $equalOrder->save();
                    }

                    $result["type"] = "success";
                    $result["message"] = "Orden creada y ejecutada con éxito.";
                }
            } else {

                $result["type"] = "error";
                $result["message"] = "Existen órdenes con precios más altos.";
            }

        } else {
            $result["type"] = "error";
            $result["message"] = "No posees fondos suficientes para realizar la operación.".floatval($walletFrom->available_balance)." asdasd ".floatval($total);
        }

        return $result;
    }

    public function askOrders()
    {
        $ccf = Input::get("currencyFrom");
        $cct = Input::get("currencyTo");

        $dbResults = DB::select("
          SELECT value, 
                 quantity as cantidad, 
                 value*quantity  as total
            from order_book 
           where crypto_currency_from = $ccf
             and crypto_currency_to = $cct
             and closed_time is null
             and type = 'ask'
           order by value asc
           limit 50");

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
                 quantity as cantidad, 
                 value*quantity  as total
            from order_book 
           where crypto_currency_from = $ccf
             and crypto_currency_to = $cct
             and closed_time is null
             and type = 'bid'
           order by value desc
           limit 50");

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
