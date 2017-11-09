<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\UserWalletTransaction;

/**
 * Class UserWalletTransactionController.
 *
 * @author  The scaffold-interface created at 2017-11-08 04:28:10am
 * @link  https://github.com/amranidev/scaffold-interface
 */
class UserWalletTransactionController extends Controller
{

    public function listByWallet($walletId)
    {
        $walletTransactions = UserWalletTransaction::where('user_wallet', $walletId)->get();

        return $walletTransactions;
    }
}
