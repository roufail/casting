<?php

namespace App\Http\Requests\Admin\Client;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'image'                 => "nullable|mimes:jpeg,jpg,png|max:512",
        ];


        if(!$this->client){
            $rules['password'] = 'required|string|min:6';
            $rules['email']    =  'required|email|unique:clients,email';
        }else {
            $rules['email']    =  'required|email|unique:clients,email,'.$this->client->id; 
        }

        return $rules;

    }
}
