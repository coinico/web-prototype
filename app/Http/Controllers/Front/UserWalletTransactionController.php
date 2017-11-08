<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserWalletTransaction;
use Amranidev\Ajaxis\Ajaxis;
use URL;

/**
 * Class User_transactions_tableController.
 *
 * @author  The scaffold-interface created at 2017-11-08 04:28:10am
 * @link  https://github.com/amranidev/scaffold-interface
 */
class UserWalletTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Index - user_transactions_table';
        $user_transactions_tables = UserWalletTransaction::paginate(6);
        return view('user_transactions_table.index',compact('user_transactions_tables','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create - user_transactions_table';
        
        return view('user_transactions_table.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_transactions_table = new UserWalletTransaction();

        
        $user_transactions_table->address_from = $request->address_from;

        
        $user_transactions_table->address_to = $request->address_to;

        
        $user_transactions_table->amount = $request->amount;

        
        $user_transactions_table->type = $request->type;

        
        $user_transactions_table->memo = $request->memo;

        
        $user_transactions_table->transaction_hash = $request->transaction_hash;

        
        $user_transactions_table->transaction_fee = $request->transaction_fee;

        
        $user_transactions_table->total = $request->total;

        
        
        $user_transactions_table->save();

        $pusher = App::make('pusher');

        //default pusher notification.
        //by default channel=test-channel,event=test-event
        //Here is a pusher notification example when you create a new resource in storage.
        //you can modify anything you want or use it wherever.
        $pusher->trigger('test-channel',
                         'test-event',
                        ['message' => 'A new user_transactions_table has been created !!']);

        return redirect('user_transactions_table');
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
        $title = 'Show - user_transactions_table';

        if($request->ajax())
        {
            return URL::to('user_transactions_table/'.$id);
        }

        $user_transactions_table = UserWalletTransaction::findOrfail($id);
        return view('user_transactions_table.show',compact('title','user_transactions_table'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        $title = 'Edit - user_transactions_table';
        if($request->ajax())
        {
            return URL::to('user_transactions_table/'. $id . '/edit');
        }

        
        $user_transactions_table = UserWalletTransaction::findOrfail($id);
        return view('user_transactions_table.edit',compact('title','user_transactions_table'  ));
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
        $user_transactions_table = UserWalletTransaction::findOrfail($id);
    	
        $user_transactions_table->address_from = $request->address_from;
        
        $user_transactions_table->address_to = $request->address_to;
        
        $user_transactions_table->amount = $request->amount;
        
        $user_transactions_table->type = $request->type;
        
        $user_transactions_table->memo = $request->memo;
        
        $user_transactions_table->transaction_hash = $request->transaction_hash;
        
        $user_transactions_table->transaction_fee = $request->transaction_fee;
        
        $user_transactions_table->total = $request->total;
        
        
        $user_transactions_table->save();

        return redirect('user_transactions_table');
    }

    /**
     * Delete confirmation message by Ajaxis.
     *
     * @link      https://github.com/amranidev/ajaxis
     * @param    \Illuminate\Http\Request  $request
     * @return  String
     */
    public function DeleteMsg($id,Request $request)
    {
        $msg = Ajaxis::MtDeleting('Warning!!','Would you like to remove This?','/user_transactions_table/'. $id . '/delete');

        if($request->ajax())
        {
            return $msg;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     	$user_transactions_table = UserWalletTransaction::findOrfail($id);
     	$user_transactions_table->delete();
        return URL::to('user_transactions_table');
    }
}
