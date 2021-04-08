<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            "id"             => $this->id,
            "email"          => $this->email,
            "country"        => $this->country,
            "image"          => $this->image ? \Storage::disk("clients")->url($this->image) : null,
            "name"           => $this->name,
            "country"        => $this->country,
            "active"         => $this->active,
            "firebase_token" => $this->firebase_token,
        ];
    }
}
