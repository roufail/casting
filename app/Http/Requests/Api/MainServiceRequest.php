<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class MainServiceRequest extends FormRequest
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
            'title'       => 'required|string',
            'description' => 'required|string',
            'image'       => "nullable|mimes:jpeg,jpg,png|max:512",
            'category_id' => "required|exists:categories,id",
        ];

        return $rules;
    }
}
