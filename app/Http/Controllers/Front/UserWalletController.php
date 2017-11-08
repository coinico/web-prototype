<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\UserWallet;

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
        $standardWallets = UserWallet::where('user_id', $userId)->get();

        return view('front.wallets.index', compact('standardWallets'));
    }
}
