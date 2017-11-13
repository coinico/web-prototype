<?php

namespace App\Http\Controllers\Back;

use App\{
    Http\Controllers\Controller, Models\Property, Repositories\PropertyVoteRepository
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

        $this->middleware('auth');
    }


    public function vote($propertyId, PropertyVoteRequest $request)
    {
        $property = Property::find($propertyId);

        if ($property && $property->user_id <> 1 && $request->vote == 1) {
            $property->status_id = 4;
            $property->save();
        }

        $propertyVote = PropertyVote::where(['property_id' => $propertyId, 'user_id' => auth()->user()->id])->first();
        if ($propertyVote) {
            $this->repository->update($propertyVote, $request);
        } else {
            $this->repository->store($propertyId, $request);
        }

        $votes = PropertyVote::where('user_id',auth()->user()->id)
            ->whereHas('properties', function($q){
                $q->where('status_id', 1);
            })->get();

        return view('front.panel.votes', compact('votes'));
    }

}
