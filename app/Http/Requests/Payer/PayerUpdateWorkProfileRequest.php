<?php

namespace App\Http\Requests\Payer;

use Illuminate\Foundation\Http\FormRequest;

class PayerUpdateWorkProfileRequest extends FormRequest
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
            'job_title'                       => 'sometimes|required',
            'prev_work'                       => 'sometimes|required',
            'bio'                             => 'sometimes|required',
            'prev_work_images'                => 'sometimes|required|Array',
            'prev_work_images.*'              => 'required',
            'prev_work_video'                 => 'sometimes|required',
            'prev_work_remove_images_ids'     => 'sometimes|required|Array',
            'prev_work_remove_images_ids.*'   => 'required|numeric'
        ];
    }
}
