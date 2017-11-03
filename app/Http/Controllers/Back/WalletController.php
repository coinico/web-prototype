<?php

namespace App\Http\Controllers\Back;

use App\ {
    Http\Controllers\Controller
};
use App\Libraries\Ethereum;

class WalletController extends Controller
{

    public $client;

    public function __construct($host = FALSE) {
        if (!$host) {
            $host = 'http://localhost:8445';
    }
        $this->client = new Ethereum($host);
    }

    public function testWallet() {
        try {
            $eth = new EthereumController();
            $eth->client->eth_protocolVersion();
        }
        catch (\Exception $exception) {
            return ("Unable to connect.");
        }
        return ("Success.");

    }

}
