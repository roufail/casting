<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PayerBankAccountDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "full_name"        => $this->full_name,
            "bank_name"        => $this->bank_name,
            "account_number"   => $this->account_number,
        ];
    }
}
