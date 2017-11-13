<?php

namespace App\Http\Controllers\Back;

use App\{
    Http\Requests\PropertyRequest, Http\Controllers\Controller, Models\CryptoCurrency, Models\UserWalletTransaction, Models\Property, Repositories\PropertyInvestRepository
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

    public function tokenizateProperty($property, $user, $transaction) {

        // efectiviza la transacción anterior
        $transaction["is_hold"] = 0;
        $transaction->save();

        $ptiName = 'TPI de '.auth()->user()->name;
        $ptiAlias = 'TPI-'.auth()->user()->id;

        $cryptoCurrency = CryptoCurrency::create(
            [
                'name' => $ptiName,
                'alias' => $ptiAlias,
                'image' => "house.png",
                'usd_value' => 10,
                "minimum_order" => 0.05,
                'type' => 'token'
            ]
        );

        $property["status_id"] = 5;
        $property->save();

        $userWallet = UserWallet::create(
            [
                'user_id' => $user->id,
                'crypto_currency' => $cryptoCurrency->id,
            ]
        );

        UserWalletTransaction::create(
            [
                'address_from' => '0xfe8f6b1a27625c2eadd2743ff963b16b1d931f61',
                'address_to' => '0xfe8f6b1a27625c2eadd2743ff963b16b1d931f61',
                'amount' => 3100,
                'type' => 'debit',
                'memo' => 'Tokenización de propiedad: '.$property->title,
                'transaction_hash' => '0xfe8f6b1a27625c2eadd2743ff963b16b1d931f61',
                'transaction_fee' => 0,
                'is_hold' => 1,
                'total' =>  3100,
                'user_wallet' => $userWallet->id,
            ]
        );

    }


    public function invest($propertyId, PropertyInvestRequest $request){

        //Chequeo si tiene fondos para realizar la inversión
        $user = auth()->user();
        $ethWallet = UserWallet::where('user_id', $user->id)->where("crypto_currency", 1)->first();

        $propertyInvest = PropertyInvest::where(['property_id'=>$propertyId, 'user_id' => auth()->user()->id])->first();
        $property = Property::find($propertyId);
        if($propertyInvest){

            $transaction = UserWalletTransaction::find($propertyInvest->transaction_id);

            if (($ethWallet->available_balance - $transaction->amount) < floatval($request->input('value'))){
                return response('Saldo no disponible', 400);
            }

            $transaction["amount"] = -floatval($request->input('value'));
            $transaction->save();

            $this->repository->update($propertyInvest, $request);

            if($property->user_id == $user->id && floatval($request->input("value")) == 100) {
                $this->tokenizateProperty($property, $user, $transaction);
            }
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

            $request->merge(['transaction_id' => $transaction->id]);

            $this->repository->store($propertyId, $request);

            if(floatval($property->user_id == $user->id && $request->input("value")) == 100) {
                $this->tokenizateProperty($property, $user, $transaction);
            }
        }

        $investments = PropertyInvest::where('user_id',auth()->user()->id)->where("value","<>", 0)
            ->whereHas('properties', function($q){
                $q->where('status_id', 4);
            })->get();
        return view('front.panel.investments', compact('investments'));
    }

}
