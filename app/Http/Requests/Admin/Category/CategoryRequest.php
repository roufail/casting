<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'title'       => 'required|string|unique:categories,id',
            'description' => 'required|string',
            'image'       => "nullable|mimes:svg|max:512",
        ];
        if($this->category){
            $rules['title'] = 'required|string|unique:categories,id,'.$this->category->id;
        }
        return $rules;
    }
}
