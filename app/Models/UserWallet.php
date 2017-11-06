<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Userwallet.
 *
 * @author  The scaffold-interface created at 2017-11-06 10:20:35pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class UserWallet extends Model
{

    public $timestamps = false;
    
    protected $table = 'user_wallets';

	
}
