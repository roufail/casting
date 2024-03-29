<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
        $rules =  [
            // 'title'                 => 'required|string|unique:user_services,id',
            'price'                 => 'sometimes|numeric',
            'work_type'             => 'sometimes|required|string',
            'category_id'           => 'sometimes|required|numeric|exists:categories,id',
            'service_id'            => 'sometimes|required|numeric|exists:services,id',
            'active'                => 'nullable'
        ];
        return $rules;    
    }
}
