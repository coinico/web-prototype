<?php

namespace App\Http\Requests;

class PropertyRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $regex = '/^[A-Za-z0-9-éèàù]{1,50}?(,[A-Za-z0-9-éèàù]{1,50})*$/';
        $id = $this->property ? ',' . $this->property->id : '';

        return $rules = [
            'title' => 'bail|required|max:255'
        ];
    }
}
