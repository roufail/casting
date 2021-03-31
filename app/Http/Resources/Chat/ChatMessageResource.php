<?php

namespace App\Http\Resources\Chat;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = "$this->user_type";
        $disk = $this->user_type."s" == "payers" ? "users" : "clients";
        return [
            "id"        =>  $this->id,
            "user"      => [
                "id"    => $this->$user->id,
                "type"  => $this->user_type,
                "name"  => $this->$user->name,
                "image" => $this->$user->image ? \Storage::disk($disk)->url($this->$user->image) : null,
            ],
            "message"      =>  $this->message,
            "message_type" =>  $this->message_type,
            "seen"         =>  $this->seen,
            "created_at"   =>  $this->created_at->format("d-m-Y h:i:s"),
        ];
    }
}
