<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SchoolRequests extends FormRequest
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
            'firstname'=> 'required|string|max:10|min:2',
            'lastname'=> 'required|string|max:10|min:2',
            'midname'=> 'required|string|max:10|min:2',
            'email'=> 'required|email|unique:School|unique:Teacher|unique:Student|unique:Parents|',
            'phone'=> 'required|numeric|digits:11|unique:School|unique:Teacher|unique:Student|unique:Parents|',
            'localaddress'=> 'required|string|max:40|min:4',
            'password'=> 'required|min:8|max:40|confirmed',

        ];
    }
}
