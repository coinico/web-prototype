<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyInvest extends Model
{

    protected $table = 'property_invests';

    protected $fillable = ['property_id', 'user_id', 'value'];

    /**
     * Many to Many relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function properties()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }
}
