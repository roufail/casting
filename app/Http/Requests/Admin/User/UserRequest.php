<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules =  [
            'name'                  => 'required|string',
            'password'              => 'nullable|string|min:6',
            'password_confirmation' => 'required_with:password|same:password',
            'country'               => 'required|string',
            'dob'                   => 'date_format:Y-m-d|before:5 years ago|nullable',
            'image'                 => "nullable|mimes:jpeg,jpg,png|max:512",
            'bio'                   => "nullable",
            'services'              => "nullable|array",
            'services.*.service_id' => "required|numeric|exists:services,id",
            'services.*.price'      => "required|numeric",
            'services.*.work_type'  => "string"
        ];
        if(!$this->user){
            $rules['password'] = 'required|string|min:6';
            $rules['email']    =  'required|email|unique:users,email';
        }else {
            $rules['email']    =  'required|email|unique:users,email,'.$this->user->id; 
        }

        return $rules;
    }
}
