<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\UserWallet;
use App\Models\UserWalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

/**
 * Class userWalletController.
 *
 * @author  The scaffold-interface created at 2017-11-06 10:20:35pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class UserWalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = auth()->user()->id;
        $standardWallets = UserWallet::whereHas('currency', function($q){
            $q->where('type', '=','currency');
        })->where('user_id', $userId)->get();

        $tokenWallets = UserWallet::whereHas('currency', function($q){
            $q->where('type', '=','token');
        })->where('user_id', $userId)->get();

        return view('front.wallets.index', compact('standardWallets', 'tokenWallets'));
    }

    public function manageWallet($id)
    {
        return UserWallet::find($id);
    }

    public function deposit(Request $request) {

        // TODO: walletId exists
        // TODO: amountToDeposit != negative
        // TODO: no fee for deposits

        $walletId = Input::get("walletId");
        $amountToDeposit = Input::get("amountToDeposit");
        $memoToDeposit = Input::get("memoToDeposit") ? Input::get("memoToDeposit") : "Depósito manual.";

        $wallet = UserWallet::find($walletId)->get();

        UserWalletTransaction::create(
            [
                'address_from' => '0x',
                'address_to' => '0xde0B295669a9FD93d5F28D9Ec85E40f4cb697BAe',
                'amount' => $amountToDeposit,
                'type' => 'credit',
                'memo' => $memoToDeposit,
                'transaction_hash' => '0x35f29841f9fe3747c0327c261019f22a08718e6650492a5ba01dc2a4b76efeb5',
                'transaction_fee' => 0,
                'total' => $amountToDeposit,
                'user_wallet' => $wallet->id,
            ]
        );

        // TODO: return what?
    }

    public function withdraw(Request $request) {

        // TODO: walletId exists
        // TODO: amountToWithdraw != negative
        // TODO: feeForWithdrawal != negative
        // TODO: validate balance >= amount + fee

        $walletId = Input::get("walletId");
        $amountToWithdraw = Input::get("amountToWithdraw");
        $feeForWithdrawal = Input::get("feeForWithdrawal");
        $memoToWithdraw = Input::get("memoToWithdraw") ? Input::get("memoToWithdraw") : "Retiro manual.";

        $total = $amountToWithdraw + $feeForWithdrawal;
        $wallet = UserWallet::find($walletId)->get();

        UserWalletTransaction::create(
            [
                'address_from' => '0xde0B295669a9FD93d5F28D9Ec85E40f4cb697BAe',
                'address_to' => '0x',
                'amount' => -$amountToWithdraw,
                'type' => 'debit',
                'memo' => $memoToWithdraw,
                'transaction_hash' => '0x35f29841f9fe3747c0327c261019f22a08718e6650492a5ba01dc2a4b76efeb5',
                'transaction_fee' => -$feeForWithdrawal,
                'total' => -$total,
                'user_wallet' => $wallet->id,
            ]
        );

        // TODO: return what?
    }
}
