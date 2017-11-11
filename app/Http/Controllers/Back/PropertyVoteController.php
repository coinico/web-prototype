<?php

namespace App\Http\Controllers\Back;

use App\{
    Http\Controllers\Controller, Repositories\PropertyVoteRepository
};
use App\Http\Requests\PropertyVoteRequest;
use App\Models\PropertyVote;


class PropertyVoteController extends Controller
{

    use Indexable;

    /**
     * Create a new PropertyController instance.
     *
     * @param  \App\Repositories\PropertyVoteRepository $repository
     */
    public function __construct(PropertyVoteRepository $repository)
    {
        $this->repository = $repository;

        $this->table = 'property_votes';
    }


    public function vote($propertyId, PropertyVoteRequest $request)
    {
        $propertyVote = PropertyVote::where(['property_id' => $propertyId, 'user_id' => auth()->user()->id])->first();
        if ($propertyVote) {
            $this->repository->update($propertyVote, $request);
        } else {
            $this->repository->store($propertyId, $request);
        }
    }

}
