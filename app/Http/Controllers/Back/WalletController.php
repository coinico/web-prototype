<?php

namespace App\Http\Controllers\Back;

use App\ {
    Http\Controllers\Controller
};
use App\Libraries\Ethereum;
use Ethereum\EthereumClient;

class WalletController extends Controller
{

    public $client;

    public function __construct($host = FALSE, $port = FALSE) {
        if (!$host) {
            $host = 'http://138.68.182.38';
            $port = '8545';
        }
        $this->client = new Ethereum($host, $port);
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
