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
        $user = User::find(auth()->id());

        //@todo: Agregar peso al voto

        $request->merge(['user_id' => $user->id]);
        $request->merge(['property_id' => $propertyId]);
        $request->merge(['weight' => 1]);

        $propertyVote = PropertyVote::create($request->all());

    }

}
