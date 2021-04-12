<?php

namespace App\Http\Resources\Service;

use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
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
            "id"     => $this->id,
            "review" => $this->feedback,
            "rate"   => $this->rate,
            "client" => [
                'id' => $this->client->id,
                'name' => $this->client->name,
                'image' => $this->client->image ? \Storage::disk("clients")->url($this->client->image) : null,
            ]
        ];
    }
}
