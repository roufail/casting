<?php

namespace App\Http\Requests\Payer;

use Illuminate\Foundation\Http\FormRequest;

class PayerUpdateDataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'              => 'sometimes|required',
            'email'             => 'sometimes|required|email|unique:users,id,'.auth()->user()->id,
            'phone'             => 'sometimes|required',
            'country'           => 'sometimes|required',
            'image'             => 'sometimes|required',
            'dob'               => 'sometimes|required|date',
            'old_password'      => 'required_with:password',
            'password'          => 'nullable',
            'password_confrim'  => 'required_with:password|same:password',
            'full_name' => 'required_with:bank_name,account_number',
            'bank_name' => 'required_with:full_name,bank_name',
            'account_number' => 'required_with:bank_name,full_name',
        ];
    }
}
