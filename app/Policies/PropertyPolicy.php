<?php

namespace App\Policies;

use App\Models\ {User, Property};

class PropertyPolicy extends Policy
{
    /**
     * Determine whether the user can manage the property.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Property  $property
     * @return mixed
     */
    public function manage(User $user, Property $property)
    {
        return $user->id === $property->user_id;
    }
}
