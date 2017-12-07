<?php

namespace App\Jobs;

use App\Models\CryptoCurrency;
use App\Models\OrderBook;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessNewOrders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ethCurrency = CryptoCurrency::find(1);

        $ctfCurrency = CryptoCurrency::find(2);

        $tokenCurrencies = CryptoCurrency::all();

        $dateYesterday = date("Y-m-d H:i:s", time() - 60 * 60 * 24);

        foreach ($tokenCurrencies as $tokenCurrency) {

            if ($tokenCurrency->id <> 1 && $tokenCurrency->id <>2) {
                for ($i = 1; $i <= 10; $i++) {
                    $this->createOrderBook(1, $ctfCurrency, $tokenCurrency);
                    $this->createOrderBookWithDate(1, $ctfCurrency, $tokenCurrency, $dateYesterday);
                    $this->createOrderBook(1, $ethCurrency, $tokenCurrency);
                    $this->createOrderBookWithDate(1, $ethCurrency, $tokenCurrency, $dateYesterday);
                }
            }
        }

    }

    private static function createRandomFloat($positive) {
        $number = rand(1, 20);
        $otherNumber = floatVal($number > 10 ? '0.' . $number : '0.0' . $number);
        if ($positive) {
            return 1+$otherNumber;
        } else {
            return 1-$otherNumber;
        }
    }

    function priceDifference($currencyFrom, $currencyTo) {
        return \App\Utils\MarketUtils::calculatePriceDifference($currencyFrom, $currencyTo);
    }

    function createOrderBook($userId, $currencyFrom, $currencyTo) {

        $booleanTypes = array(1, 0);
        $quantity = rand(1, 5000);
        $currencyFromAvgValue = $this->priceDifference($currencyFrom, $currencyTo);
        $value = $currencyFromAvgValue * $this->createRandomFloat(array_random($booleanTypes));

        $currentCost = $value * $quantity;
        if ($value > $currencyFromAvgValue) {
            $type = "ask";
            $executionType = "sell";
        }else {
            $executionType = "buy";
            $type = "bid";
            $currentCost = -$currentCost;
        }

        $cerrar = array_random($booleanTypes);

        if ($cerrar) {
            OrderBook::create(
                [
                    'user_id' => $userId,
                    'crypto_currency_from' => $currencyFrom->id,
                    'crypto_currency_to' => $currencyTo->id,
                    'type' => $type,
                    'quantity' => $quantity,
                    'value' => $value,
                    'filled' => $quantity,
                    'current_cost' => $currentCost,
                    'execution_type' => $executionType,
                    'created_at' => \Carbon\Carbon::now()->subMinutes(rand(18000, 28000))->format('Y-m-d H:i:s'),
                    'closed_time' => \Carbon\Carbon::now()->subMinutes(rand(1, 17999))->format('Y-m-d H:i:s')
                ]
            );
        } else {
            OrderBook::create(
                [
                    'user_id' => $userId,
                    'crypto_currency_from' => $currencyFrom->id,
                    'crypto_currency_to' => $currencyTo->id,
                    'type' => $type,
                    'quantity' => $quantity,
                    'value' => $value,
                    'execution_type' => $executionType,
                    'created_at' => \Carbon\Carbon::now()->subMinutes(rand(1, 17999))->format('Y-m-d H:i:s')
                ]
            );
        }
    }

    function createOrderBookWithDate($userId, $currencyFrom, $currencyTo, $date) {

        $booleanTypes = array(1, 0);
        $quantity = rand(1, 5000);
        $currencyFromAvgValue = $this->priceDifference($currencyFrom, $currencyTo);
        $value = $currencyFromAvgValue * $this->createRandomFloat(array_random($booleanTypes));
        $currentCost = $value * $quantity;

        if ($value > $currencyFromAvgValue) {
            $type = "ask";
            $executionType = "sell";
        }else {
            $executionType = "buy";
            $type = "bid";
            $currentCost = -$currentCost;
        }

        $cerrar = array_random($booleanTypes);

        if ($cerrar) {
            OrderBook::create(
                [
                    'user_id' => $userId,
                    'crypto_currency_from' => $currencyFrom->id,
                    'crypto_currency_to' => $currencyTo->id,
                    'execution_type' => $executionType,
                    'quantity' => $quantity,
                    'value' => $value,
                    'filled' => $quantity,
                    'current_cost' => $currentCost,
                    'type' => $type,
                    'created_at' => \Carbon\Carbon::now()->subMinutes(rand(18000, 28000))->format('Y-m-d H:i:s'),
                    'closed_time' => \Carbon\Carbon::now()->subMinutes(rand(1, 17999))->format('Y-m-d H:i:s'),
                    'updated_at' => $date
                ]
            );
        } else {
            OrderBook::create(
                [
                    'user_id' => $userId,
                    'crypto_currency_from' => $currencyFrom->id,
                    'crypto_currency_to' => $currencyTo->id,
                    'type' => $type,
                    'quantity' => $quantity,
                    'value' => $value,
                    'execution_type' => $executionType,
                    'created_at' => \Carbon\Carbon::now()->subMinutes(rand(1, 17999))->format('Y-m-d H:i:s'),
                    'updated_at' => $date
                ]
            );
        }
    }

}
