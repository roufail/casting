<?php

namespace App\Http\Requests\Payer;

use Illuminate\Foundation\Http\FormRequest;

class PayerRegisterRequest extends FormRequest
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
            'email'             => 'required|unique:users,email',
            'country'           => 'required',
            'password'          => 'required',
            'confirm_password'  => 'required|same:password',
            'image'             => 'nullable',
            'phone'             => 'required|unique:users,phone',
            'dob'               => 'required|date',
        ];
    }
}
