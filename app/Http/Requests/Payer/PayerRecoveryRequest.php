<?php

namespace App\Http\Requests\Payer;

use Illuminate\Foundation\Http\FormRequest;

class PayerRecoveryRequest extends FormRequest
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
            'phone'             => 'required',
            'code'              => 'required',
            'password'          => 'required',
            'confirm_password'  => 'required|same:password',
            'firebase_token'    => 'nullable',
        ];
    }
}
