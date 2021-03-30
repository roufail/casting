<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use \Illuminate\Contracts\Validation\Validator;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth("client-api")->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password'          => 'required|string|min:6',
            'password'              => 'required|string|min:6',
            'password_confirmation' => 'required|same:password|min:6',
        ];
    }

    protected function failedValidation(Validator $validator) { 
        throw new HttpResponseException(
          response()->json([
            'message' =>'validation errors',
            'errors'  => $validator->errors()->all()
          ], 422)
        ); 
      }

}
