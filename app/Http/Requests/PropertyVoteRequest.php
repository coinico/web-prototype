<?php

namespace App\Http\Requests;

class PropertyVoteRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $rules = [
            'vote' => 'bail|required|integer'
        ];
    }
}
