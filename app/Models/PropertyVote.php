<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyVote extends Model
{

    protected $table = 'property_votes';

    protected $fillable = ['property_id', 'user_id', 'vote', 'weight'];

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
