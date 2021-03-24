<?php

namespace App\Http\Requests\Admin\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
        ];

        if(!$this->admin){
            $rules['password'] =  'required|string|min:6';
            $rules['email']    =  'required|email|unique:admins,email';
        }else {
            $rules['email']    =  'required|email|unique:admins,email,'.$this->admin->id; 
        }

        return $rules;
    }
}
