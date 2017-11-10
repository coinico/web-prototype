<?php

namespace App\Http\Controllers\Back;

use App\ {
    Http\Requests\PropertyRequest,
    Http\Controllers\Controller,
    Models\PropertyStatus,
    Models\Property,
    Repositories\PropertyInvestRepository
};
use Illuminate\Http\Request;
use App\Models\PropertyInvest;
use App\Http\Requests\PropertyInvestRequest;


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
        $propertyInvest = PropertyInvest::where(['property_id'=>$propertyId, 'user_id' => auth()->user()->id])->first();
        if($propertyInvest){
            $this->repository->update($propertyInvest, $request);
        }else{
            $this->repository->store($propertyId, $request);
        }
    }

}
