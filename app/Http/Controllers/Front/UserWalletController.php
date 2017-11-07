<?php

namespace App\Http\Controllers\Front;

use App\Models\CryptoCurrency;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserWallet;
use URL;
use Illuminate\Support\Facades\Input;

/**
 * Class userWalletController.
 *
 * @author  The scaffold-interface created at 2017-11-06 10:20:35pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class userWalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Índice - User Wallet';
        $userWallets = UserWallet::paginate(6);
        return view('front.user_wallet.index',compact('userWallets','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {

        $cryptoCurrencies = CryptoCurrency::all()->pluck('alias', 'id');

        return view('front.user_wallet.create', compact('cryptoCurrencies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge(['user_id' => auth()->id()]);
        $request->merge(['crypto_currency' => $request->crypto_currency_id]);

        $userWallet = UserWallet::create($request->all());

        $pusher = App::make('pusher');

        //default pusher notification.
        //by default channel=test-channel,event=test-event
        //Here is a pusher notification example when you create a new resource in storage.
        //you can modify anything you want or use it wherever.
        $pusher->trigger('test-channel',
                         'test-event',
                        ['message' => 'Un nuevo wallet user ha sido creado. !!']);

        return redirect('userWallet');
    }

    /**
     * Display the specified resource.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {
        $title = 'Mostrar User Wallet';

        if($request->ajax())
        {
            return URL::to('userWallet/'.$id);
        }

        $userWallet = UserWallet::findOrfail($id);
        return view('front.user_wallet.show',compact('title','userWallet'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        if($request->ajax())
        {
            return URL::to('userWallet/'. $id . '/edit');
        }

        $users = User::all()->pluck('id', 'name');
        $cryptoCurrencies = CryptoCurrency::all()->pluck('id', 'alias');

        $userWallet = UserWallet::findOrfail($id);
        return view('front.user_wallet.edit',compact('userWallet', 'users', 'cryptoCurrencies'  ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        $userWallet = UserWallet::findOrfail($id);
    	
        $userWallet->balance = $request->balance;
        
        
        $userWallet->save();

        return redirect('userWallet');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     	$userWallet = UserWallet::findOrfail($id);
     	$userWallet->delete();
        return URL::to('userWallet');
    }
}
