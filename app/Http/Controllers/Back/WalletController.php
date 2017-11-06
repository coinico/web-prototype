<?php

namespace App\Http\Controllers\Back;

use App\Libraries\Ethereum;
use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\User;

class WalletController extends Controller
{

    public $client;

    public function __construct($host = FALSE, $port = FALSE) {
        if (!$host) {

            $host = 'http://127.0.0.1';
            $port = '8545';
        }
        $this->client = new Ethereum($host, $port);
    }


    /**
     * Display a listing of the wallets.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = auth()->user()->id;
        $wallets = Wallet::where('user_id', $userId)->get();

        return view('front.wallets.index', compact('wallets'));
    }

    /**
     * Show the form for creating a new wallet.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        return view('front.wallets.create');
    }

    /**
     * Set eth and ctf wallets and user seedphrase
     *
     * @return \Illuminate\Http\Response
     */
    public function start() {

        $user = User::find(auth()->user()->id);
        $wallets = Wallet::where('user_id', $user->getAttribute('id'))->count();
        if(!$wallets){ //Initial config
            $user->setSeedPhrase();
            //@todo: Agregar billteras
        }

    }

}
