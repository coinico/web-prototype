<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\userWallet;
use Amranidev\Ajaxis\Ajaxis;
use URL;

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
        $userWallets = userWallet::paginate(6);
        return view('front.user_wallet.index',compact('userWallets','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        return view('front.user_wallet.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userWallet = new userWallet();

        $userWallet->balance = $request->balance;

        $userWallet->save();

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

        $userWallet = userWallet::findOrfail($id);
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
        $title = 'Edit - userWallet';
        if($request->ajax())
        {
            return URL::to('userWallet/'. $id . '/edit');
        }

        
        $userWallet = userWallet::findOrfail($id);
        return view('front.user_wallet.edit',compact('title','userWallet'  ));
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
        $userWallet = userWallet::findOrfail($id);
    	
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
     	$userWallet = userWallet::findOrfail($id);
     	$userWallet->delete();
        return URL::to('userWallet');
    }
}
