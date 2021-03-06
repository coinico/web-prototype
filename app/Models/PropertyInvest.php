<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyInvest extends Model
{

    protected $table = 'property_invests';

    protected $fillable = ['property_id', 'user_id', 'value', "transaction_id"];

    /**
     * Many to Many relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function properties()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    public function property()
    {
        $property = Property::find($this->getAttribute('property_id'));
        return $property;
    }
}
