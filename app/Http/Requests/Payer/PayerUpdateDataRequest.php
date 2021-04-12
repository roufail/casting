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
            'name'              => 'required',
            'email'             => 'required|email|unique:users,id,'.auth()->user()->id,
            'phone'             => 'required',
            'country'           => 'required',
            'image'             => 'required',
            'dob'               => 'required|date',
            'job_title'         => 'required',
            'prev_work'         => 'required',
            'bio'               => 'required',
            'password'          => 'nullable',
            'password_confrim'  => 'required_with:password|same:password',
        ];
    }
}
