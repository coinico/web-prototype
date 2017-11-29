<?php

use Illuminate\Database\Seeder;
use App\Models\CryptoCurrency;
use App\Models\User;
use App\Models\UserWallet;
use App\Models\UserWalletTransaction;
use App\Models\OrderBook;

class DatabaseSeeder extends Seeder
{

    public function dummusercreation($number) {
        User::create(
            [
                'name' => 'dummy'.$number,
                'email' => 'dummy'.$number.'@gmail.com',
                'password' => bcrypt('admin'),
                'role' => 'admin',
                'valid' => true,
                'confirmed' => true,
                'remember_token' => str_random(10),
            ]
        );
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::create(
            [
                'name' => 'lnacosta',
                'email' => 'laion.cj91@gmail.com',
                'password' => bcrypt('admin'),
                'role' => 'admin',
                'valid' => true,
                'confirmed' => true,
                'remember_token' => str_random(10),
            ]
        );

        for ($i = 1; $i <= 15; $i++) {
            $this->dummusercreation($i);
        }

        $ethCurrency = CryptoCurrency::create(
            [
                'name' => 'Ethereum',
                'alias' => 'ETH',
                'image' => 'eth-logo.png',
                'usd_value' => 473.22,
                "minimum_order" => 0.005,
                'type' => 'currency'
            ]
        );

        $ctfCurrency = CryptoCurrency::create(
            [
                'name' => 'CasaToken',
                'alias' => 'CTK',
                'image' => 'logo_dark.png',
                'usd_value' => 1.01,
                "minimum_order" => 0.05,
                'type' => 'currency'
            ]
        );

        $tokenCurrencies = array();

        $tokenCurrencies[] = $this->createCurrency("TPI-ARBN-001", "ARBN1", "house1.png", 10.5);
        $tokenCurrencies[] = $this->createCurrency("TPI-ARPD-004", "ARPD4", "house2.png", 9);
        $tokenCurrencies[] = $this->createCurrency("TPI-ARTT-007", "ARTT7", "house3.png", 8);
        $tokenCurrencies[] = $this->createCurrency("TPI-ARGN-008", "ARGN8", "house4.png", 11);
        $tokenCurrencies[] = $this->createCurrency("TPI-ARHP-009", "ARHP9", "house5.png", 12.45);
        $tokenCurrencies[] = $this->createCurrency("TPI-ARTY-002", "ARTY2", "house6.png", 3.22);
        $tokenCurrencies[] = $this->createCurrency("TPI-ARYC-005", "ARYC5", "house7.png", 8.75456);
        $tokenCurrencies[] = $this->createCurrency("TPI-ARRR-003", "ARRR3", "house8.png", 10.777);

        $ethWallet = UserWallet::create(
            [
                'user_id' => $user->id,
                'crypto_currency' => $ethCurrency->id,
            ]
        );

        $ctfWallet = UserWallet::create(
            [
                'user_id' => $user->id,
                'crypto_currency' => $ctfCurrency->id,
            ]
        );

        UserWalletTransaction::create(
            [
                'address_from' => '0x',
                'address_to' => '0xfe8f6b1a27625c2eadd2743ff963b16b1d931f61',
                'amount' => 100,
                'type' => 'credit',
                'memo' => 'Depósito inicial.',
                'transaction_hash' => '0xfe8f6b1a27625c2eadd2743ff963b16b1d931f61',
                'transaction_fee' => 0.0002,
                'total' => 100.0002,
                'user_wallet' => $ethWallet->id,
            ]
        );

        UserWalletTransaction::create(
            [
                'address_from' => '0x',
                'address_to' => '0xfe8f6b1a27625c2eadd2743ff963b16b1d931f61',
                'amount' => 10000,
                'type' => 'credit',
                'memo' => 'Depósito inicial.',
                'transaction_hash' => '0xfe8f6b1a27625c2eadd2743ff963b16b1d931f61',
                'transaction_fee' => 0.02,
                'total' => 10000.02,
                'user_wallet' => $ctfWallet->id,
            ]
        );

        $dateYesterday = date("Y-m-d H:i:s", time() - 60 * 60 * 24);

        for ($i = 1; $i <= 60; $i++) {
            $this->createOrderBook($user->id, $ethCurrency, $ctfCurrency);
            $this->createOrderBookWithDate($user->id, $ethCurrency, $ctfCurrency, $dateYesterday);
        }

        foreach ($tokenCurrencies as $tokenCurrency) {
            UserWallet::create(
                [
                    'user_id' => $user->id,
                    'crypto_currency' => $tokenCurrency->id,
                ]
            );
            for ($i = 1; $i <= 60; $i++) {
                $this->createOrderBook($user->id, $ctfCurrency, $tokenCurrency);
                $this->createOrderBookWithDate($user->id, $ctfCurrency, $tokenCurrency, $dateYesterday);
                $this->createOrderBook($user->id, $ethCurrency, $tokenCurrency);
                $this->createOrderBookWithDate($user->id, $ethCurrency, $tokenCurrency, $dateYesterday);
            }
        }

        $this->call([
            PropertiesTableSeeder::class,
        ]);

    }

    function createCurrency($name, $alias, $image, $usd_value) {
        return CryptoCurrency::create(
            [
                'name' => $name,
                'alias' => $alias,
                'image' => $image,
                'usd_value' => $usd_value,
                "minimum_order" => 0.05,
                'type' => 'token'
            ]
        );
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
