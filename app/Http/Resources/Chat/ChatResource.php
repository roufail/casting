<?php

namespace App\Http\Resources\Chat;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PayerResource;
use Storage;
class ChatResource extends JsonResource
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
            "id"         => $this->id,
            "payer"      => [
                    "id"        => $this->payer->id,
                    "name"      => $this->payer->name,
                    "image"     => $this->payer->image && $this->payer->image != "" ? Storage::disk("users")->url($this->payer->image) : null,
            ],
            "client"     => [
                    "id"        => $this->client->id,
                    "name"      => $this->client->name,
                    "image"     => $this->client->image && $this->client->image != "" ? Storage::disk("clients")->url($this->client->image) : null,
            ],
            "order_id"   => $this->order_id,
            // "created_at" => $this->created_at,
            // "updated_at" => $this->updated_at,
            "messages"   => $this->when($this->load_messages || !isset($this->load_messages),new ChatMessageCollection($this->messages()->orderby("created_at","desc")->paginate(20)))
        ];
    }
}
