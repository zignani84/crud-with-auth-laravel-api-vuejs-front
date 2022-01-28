<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
    public static function rules($merge=[])
    {
        return array_merge(
            [
                'name'    => 'required|string|between:2,100',
                'email'    => 'required|string|email|max:100',
                'phone'   => 'string|between:13,18',
            ], 
            $merge);
    }
}
