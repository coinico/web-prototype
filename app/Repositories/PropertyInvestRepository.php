<?php

namespace App\Repositories;

use App\Models\ {
    PropertyVote,
    Tag,
    Comment
};
use App\Services\Thumb;
use phpDocumentor\Reflection\Types\Boolean;
use App\Models\PropertyInvest;

class PropertyInvestRepository
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
     * @param  \App\Models\PropertyInvest $propertyInvest
     *
     */
    public function __construct(PropertyInvest $propertyInvest)
    {
        $this->model = $propertyInvest;

    }

    /**
     * Update property vote.
     *
     * @param  \App\Models\Property  $propertyInvest
     * @param  \App\Http\Requests\PropertyInvestRequest  $request
     * @return void
     */
    public function update($propertyInvest, $request)
    {
        $propertyInvest->update($request->all());
    }

    /**
     * Store property.
     *
     * @param Integer
     * @param  \App\Http\Requests\PropertyInvestRequest  $request
     * @return void
     */
    public function store($propertyId, $request)
    {
        $request->merge(['user_id' => auth()->id()]);
        $request->merge(['property_id' => $propertyId]);

        $propertyInvest = PropertyInvest::create($request->all());

    }

}
