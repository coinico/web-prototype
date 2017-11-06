<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CryptoCurrency;
use URL;

/**
 * Class Crypto_currencyController.
 *
 * @author  The scaffold-interface created at 2017-11-06 05:56:31pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class CryptoCurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Index - crypto_currency';
        $crypto_currencies = CryptoCurrency::paginate(6);
        return view('front.crypto_currency.index',compact('crypto_currencies','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        return view('front.crypto_currency.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $crypto_currency = new CryptoCurrency();

        
        $crypto_currency->name = $request->name;

        
        $crypto_currency->alias = $request->alias;

        
        $crypto_currency->image = $request->image;

        
        $crypto_currency->usd_value = $request->usd_value;

        
        
        $crypto_currency->save();

        $pusher = App::make('pusher');

        //default pusher notification.
        //by default channel=test-channel,event=test-event
        //Here is a pusher notification example when you create a new resource in storage.
        //you can modify anything you want or use it wherever.
        $pusher->trigger('test-channel',
                         'test-event',
                        ['message' => 'A new crypto_currency has been created !!']);

        return redirect('cryptoCurrency');
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
        $title = 'Show - crypto_currency';

        if($request->ajax())
        {
            return URL::to('cryptoCurrency/'.$id);
        }

        $crypto_currency = CryptoCurrency::findOrfail($id);
        return view('front.crypto_currency.show',compact('title','crypto_currency'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        $title = 'Edit - crypto_currency';
        if($request->ajax())
        {
            return URL::to('cryptoCurrency/'. $id . '/edit');
        }

        
        $crypto_currency = CryptoCurrency::findOrfail($id);
        return view('front.crypto_currency.edit',compact('title','crypto_currency'  ));
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
        $crypto_currency = CryptoCurrency::findOrfail($id);
    	
        $crypto_currency->name = $request->name;
        
        $crypto_currency->alias = $request->alias;
        
        $crypto_currency->image = $request->image;
        
        $crypto_currency->usd_value = $request->usd_value;
        
        
        $crypto_currency->save();

        return redirect('cryptoCurrency');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     	$crypto_currency = CryptoCurrency::findOrfail($id);
     	$crypto_currency->delete();
        return URL::to('cryptoCurrency');
    }
}
