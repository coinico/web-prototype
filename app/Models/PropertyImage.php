<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    protected $table = 'property_images';

    /**
     * Many to Many relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function properties()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    public function getPath()
    {

    }
}
