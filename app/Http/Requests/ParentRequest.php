<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParentRequest extends FormRequest
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
            'firstname' =>'required|string|max:15|min:2',
            'lastname' =>'required|string|max:15|min:2',
            'midname' =>'required|string|max:15|min:2',
            'email' =>'required|email|unique:School|unique:Teacher|unique:Student|unique:Parents|',
            'phone' =>'required|numeric|digits:11|unique:School|unique:Teacher|unique:Student|unique:Parents|',
            'localaddress' =>'required|string|max:40|min:4',
            'schoolcode' =>'required|string|min:13|max:13|exists:School,par_reg_code',
            'day' =>'required|integer|between:1,31',
            'mon' =>'required|integer|between:1,12',
            'year' =>'required|integer|digits:4|between:1960,2020',
            'gender' =>'required|string|between:4,6',
            'password' =>'required|min:8|max:40|confirmed',
            'schoolname' =>'required|min:8|max:50|exists:School,name',
            'child_code' =>'required|min:13|max:13|exists:Student,parent_code',
        ];
    }
}
