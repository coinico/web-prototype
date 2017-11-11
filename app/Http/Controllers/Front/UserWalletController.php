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

        $userWallet = UserWallet::find($id);

        $message = "";

        return view('front.wallets.manage', compact('userWallet', 'message'));
    }

    public function deposit($id) {

        $userWallet = UserWallet::find($id);

        $amountToDeposit = Input::get("cantidad");
        $memoToDeposit = Input::get("memo") ? Input::get("memo") : "Depósito manual.";

        if ($amountToDeposit <= 0) {

            $message = "No se pueden depositar valores negativos o nulos.";

            return view('front.wallets.manage', compact('userWallet', 'message'));
        }

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
                'user_wallet' => $id,
            ]
        );

        $message = "Operación realizada con éxito.";

        return view('front.wallets.manage', compact('userWallet', 'message'));

    }

    public function withdraw($id) {

        $userWallet = UserWallet::find($id);
        $amountToWithdraw = Input::get("cantidad");
        $memoToWithdraw = Input::get("memo") ? Input::get("memo") : "Retiro manual.";

        if ($amountToWithdraw <= 0) {

            $message = "No se pueden retirar valores negativos o nulos.";

            return view('front.wallets.manage', compact('userWallet', 'message'));
        }


        if ($userWallet->available_balance < $amountToWithdraw) {

            $message = "No tienes fondos suficientes para hacer el retiro.";

            return view('front.wallets.manage', compact('userWallet', 'message'));
        }

        UserWalletTransaction::create(
            [
                'address_from' => '0xde0B295669a9FD93d5F28D9Ec85E40f4cb697BAe',
                'address_to' => '0x',
                'amount' => -$amountToWithdraw,
                'type' => 'debit',
                'memo' => $memoToWithdraw,
                'transaction_hash' => '0x35f29841f9fe3747c0327c261019f22a08718e6650492a5ba01dc2a4b76efeb5',
                'transaction_fee' => -0,
                'total' => -$amountToWithdraw,
                'user_wallet' => $id,
            ]
        );

        $userWallet = UserWallet::find($id);

        $message = "Operación realizada con éxito.";

        return view('front.wallets.manage', compact('userWallet', 'message'));
    }
}
