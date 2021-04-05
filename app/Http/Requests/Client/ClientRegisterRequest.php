<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class ClientRegisterRequest extends FormRequest
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
            'name'              => 'required',
            'email'             => 'required|unique:clients,email',
            'country'           => 'required',
            'password'          => 'required',
            'confirm_password'  => 'required|same:password',
            'image'             => 'nullable',
            'phone'             => 'required|unique:clients,phone',
            'firebase_token'    => 'nullable',
        ];
    }
}
