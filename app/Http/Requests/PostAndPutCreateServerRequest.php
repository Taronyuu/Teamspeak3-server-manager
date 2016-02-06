<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PostAndPutCreateServerRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'  => 'required|min:4|max:100',
            'slots' => 'required|min:1|max:9999'
        ];
    }
}
