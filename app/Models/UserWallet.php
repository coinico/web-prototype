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
        'available_balance', 'book_balance', 'user_id','crypto_currency'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function currency()
    {
        return $this->belongsTo(CryptoCurrency::class, 'crypto_currency');

    }
	
}
