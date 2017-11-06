<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Crypto_currency.
 *
 * @author  The scaffold-interface created at 2017-11-06 05:56:31pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class CryptoCurrency extends Model
{
	
	
    public $timestamps = false;
    
    protected $table = 'crypto_currencies';

	
}
