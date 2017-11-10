<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserWalletTransaction.
 *
 * @author  The scaffold-interface created at 2017-11-08 04:28:10am
 * @link  https://github.com/amranidev/scaffold-interface
 */
class UserWalletTransaction extends Model
{

    protected $table = 'user_wallet_transactions';

    protected $fillable = [
        'user_wallet', 'total', 'transaction_fee',
        'transaction_hash', 'memo', 'type','amount',
        'address_to', 'address_from', 'is_hold'
    ];

    public function userWallet()
    {
        return $this->belongsTo(UserWallet::class, 'user_wallet');

    }
}
