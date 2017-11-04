<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Libraries\Ethereum;
use Illuminate\Support\Facades\Input;

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

    public function create() {

        return view('front.wallet.create-wallet');
    }

    public function createWallet() {

        try {
            $password =  Input::get('password', "nopassword");
            $eth = new WalletController();
            $privateKey = $eth->client->personal_newAccount($password);

        } catch (\Exception $exception) {
            return ($exception);
        }
        return view('front.wallet.wallet-created', compact('privateKey', 'password'));
    }
}
