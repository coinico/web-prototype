<?php

namespace App\Http\Controllers\Back;

use App\ {
    Http\Requests\PropertyRequest,
    Http\Controllers\Controller,
    Models\UserWalletTransaction,
    Models\Property,
    Repositories\PropertyInvestRepository
};
use Illuminate\Http\Request;
use App\Models\PropertyInvest;
use App\Http\Requests\PropertyInvestRequest;
use App\Models\UserWallet;

class PropertyInvestController extends Controller
{

    use Indexable;

    /**
     * Create a new PropertyController instance.
     *
     * @param  \App\Repositories\PropertyInvestRepository $repository
     */
    public function __construct(PropertyInvestRepository $repository)
    {
        $this->repository = $repository;

        $this->table = 'property_invests';
    }


    public function invest($propertyId, PropertyInvestRequest $request){

        //Chequeo si tiene fondos para realizar la inversión
        $user = auth()->user();
        $ethWallet = UserWallet::where(['user_id'=>$user->id, 'crypto_currency'=>0])->first();

        $propertyInvest = PropertyInvest::where(['property_id'=>$propertyId, 'user_id' => auth()->user()->id])->first();
        $property = Property::find($propertyId);
        if($propertyInvest){

            $transaction = UserWalletTransaction::find($propertyInvest->transaction_id);

            if (($ethWallet->available_balance - $transaction->amount) < floatval($request->input('value'))){
                return response('Saldo no disponible', 400);
            }

            $transaction["amount"] = floatval($request->input('value'));
            $transaction->save();

            $this->repository->update($propertyInvest, $request);
        }else{

            if($ethWallet->available_balance < floatval($request->input('value'))){
                return response('Saldo no disponible', 400);
            }

            $transaction = UserWalletTransaction::create(
                [
                    'address_from' => '0xfe8f6b1a27625c2eadd2743ff963b16b1d931f61',
                    'address_to' => '0xfe8f6b1a27625c2eadd2743ff963b16b1d931f61',
                    'amount' => -floatval($request->input('value')),
                    'type' => 'debit',
                    'memo' => 'Contribución en inversión: '.$property->title,
                    'transaction_hash' => '0xfe8f6b1a27625c2eadd2743ff963b16b1d931f61',
                    'transaction_fee' => 0,
                    'is_hold' => 1,
                    'total' => -floatval($request->input('value')),
                    'user_wallet' => $ethWallet->id,
                ]
            );

            $request["transaction_id"] = $transaction->id;

            $this->repository->store($propertyId, $request);
        }

        $investments = PropertyInvest::where('user_id',auth()->user()->id)->where("value","<>", 0)->get();
        return view('front.panel.investments', compact('investments'));
    }

}
