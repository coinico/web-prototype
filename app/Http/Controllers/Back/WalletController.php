<?php

namespace App\Http\Controllers\Back;

use App\ {
    Http\Controllers\Controller
};
use Ethereum\EthereumClient;

class WalletController extends Controller
{

    public $client;

    public function __construct($host = FALSE) {
        if (!$host) {
            $host = 'http://localhost:8445';
    }
        $this->client = new EthereumClient($host);
    }

    public function testWallet() {
        try {
            $eth = new WalletController();
            $eth->client->eth_protocolVersion();
        }
        catch (\Exception $exception) {
            return ("Unable to connect.");
        }
        return ("Success.");

    }

}
