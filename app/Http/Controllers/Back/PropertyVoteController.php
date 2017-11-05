<?php

namespace App\Http\Controllers\Back;

use App\ {
    Http\Requests\PropertyRequest,
    Http\Controllers\Controller,
    Models\PropertyStatus,
    Models\Property,
    Repositories\PropertyVoteRepository
};
use Illuminate\Http\Request;
use App\Models\PropertyVote;
use App\Http\Requests\PropertyVoteRequest;


class PropertyVoteController extends Controller
{

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


    public function vote($propertyId, PropertyVoteRequest $request){
        $propertyVote = PropertyVote::where('property_id',$propertyId)->first();
        if($propertyVote){
            $this->repository->update($propertyVote, $request);
        }else{
            $this->repository->store($propertyId, $request);
        }
    }

}
