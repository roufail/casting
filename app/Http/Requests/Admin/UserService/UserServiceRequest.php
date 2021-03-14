<?php

namespace App\Http\Requests\Admin\UserService;

use Illuminate\Foundation\Http\FormRequest;

class UserServiceRequest extends FormRequest
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
            'user_id'    => "required|exists:users,id",
            'service_id' => "required|exists:services,id",
            'price'      => "required|numeric",
            'work_type'  => "required",
        ];
        return $rules;
    }
}
