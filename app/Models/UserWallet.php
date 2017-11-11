<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Userwallet.
 *
 * @author  The scaffold-interface created at 2017-11-06 10:20:35pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class UserWallet extends Model
{

    protected $table = 'user_wallets';

    protected $fillable = [
        'user_id','crypto_currency'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function currency()
    {
        return $this->belongsTo(CryptoCurrency::class, 'crypto_currency');

    }

    public function transactions()
    {
        return $this->hasMany(UserWalletTransaction::class,'user_wallet', 'id');
    }

    public function getAvailableBalanceAttribute()
    {
        $ordersFrom = OrderBook::where("user_id", $this->user_id)
            ->where("crypto_currency_from", $this->crypto_currency)
            ->where("type", "bid")
            ->whereNull("closed_time")->get();

        $ordersTo = OrderBook::where("user_id", $this->user_id)
            ->where("crypto_currency_to", $this->crypto_currency)
            ->where("type", "ask")
            ->whereNull("closed_time")->get();

        $orderSum = 0;
        if ($ordersFrom) {
            foreach ($ordersFrom as $order) {
                $orderSum -= ($order->quantity) - $order->filled;
            }
        }
        if ($ordersTo) {
            foreach ($ordersTo as $order) {
                $orderSum -= ($order->quantity) - $order->filled;
            }
        }
        return $this->transactions->sum( 'amount' )-$orderSum;
    }

    public function getRealBalanceAttribute()
    {
        return $this->transactions->sum('amount');
    }

    public function getCurrency()
    {
        return CryptoCurrency::find($this->crypto_currency)->first()->alias;
    }

}
