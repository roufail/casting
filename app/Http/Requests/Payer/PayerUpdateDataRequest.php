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
            'job_title'         => 'sometimes|required',
            'prev_work'         => 'sometimes|required',
            'bio'               => 'sometimes|required',
            'password'          => 'nullable',
            'password_confrim'  => 'required_with:password|same:password',
        ];
    }
}
