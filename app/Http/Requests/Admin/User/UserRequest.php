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
            'job_title'             => "required",
            'prev_work'             => "required",
            'bio'                   => "required",
            'services'              => "nullable|array",
            'services.*.service_id' => "required|numeric|exists:services,id",
            'services.*.price'      => "required|numeric",
            'work_images'          => "nullable|array",
            'work_images.*'        => "required|String",
            'services.*.work_type' => "string",
            'full_name' => 'required_with:bank_name,account_number',
            'bank_name' => 'required_with:full_name,bank_name',
            'account_number' => 'required_with:bank_name,full_name',
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
