<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'user_id'         => 'required|exists:users,id',
            // 'client_id'       => 'required|exists:clients,id',
            'user_service_id' => 'required|exists:user_services,id',
            'status'          => 'required|in:'.implode(",",get_status()),
            // 'price'           => 'required|numaric',
        ];
    }
}
