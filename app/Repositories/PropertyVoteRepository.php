<?php

namespace App\Repositories;

use App\Models\ {
    PropertyVote,
    Tag,
    Comment
};
use App\Services\Thumb;
use phpDocumentor\Reflection\Types\Boolean;
use App\Models\User;
use App\Models\UserWallet;


class PropertyVoteRepository
{
    /**
     * The Model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;


    /**
     * Create a new BlogRepository instance.
     *
     * @param  \App\Models\PropertyVote $propertyVote
     *
     */
    public function __construct(PropertyVote $propertyVote)
    {
        $this->model = $propertyVote;

    }

    /**
     * Update property vote.
     *
     * @param  \App\Models\Property  $propertyVote
     * @param  \App\Http\Requests\PropertyVoteRequest  $request
     * @return void
     */
    public function update($propertyVote, $request)
    {
        $propertyVote->update($request->all());
    }

    /**
     * Store property.
     *
     * @param Integer
     * @param  \App\Http\Requests\PropertyVoteRequest  $request
     * @return void
     */
    public function store($propertyId, $request)
    {
        $user = auth()->user();
        $ethWallet = UserWallet::where(['user_id'=>$user->id, 'crypto_currency'=>1])->first();

        $weight = $ethWallet->available_balance;

        $request->merge(['user_id' => auth()->id()]);
        $request->merge(['property_id' => $propertyId]);
        $request->merge(['weight' => $weight]);

        $propertyVote = PropertyVote::create($request->all());

    }

}
