<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\UserWallet;
use App\Models\UserWalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

/**
 * Class OrderBookController.
 *
 * @author  The scaffold-interface created at 2017-11-06 10:20:35pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class OrderBookController extends Controller
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
}
