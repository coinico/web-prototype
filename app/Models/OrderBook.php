<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderBook.
 *
 * @author  lnacosta
 */
class OrderBook extends Model
{
    public $timestamps = true;

    protected $table = 'order_book';

    protected $fillable = [
        'user_id', 'crypto_currency_from', 'crypto_currency_to',
        'type', 'quantity', 'value','execution_type',
        'closed_time', 'created_at', 'filled', 'current_cost'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');

    }

    public function cryptoCurrencyFrom()
    {
        return $this->belongsTo(CryptoCurrency::class, 'crypto_currency_from');

    }

    public function cryptoCurrencyTo()
    {
        return $this->belongsTo(CryptoCurrency::class, 'crypto_currency_to');

    }
}
