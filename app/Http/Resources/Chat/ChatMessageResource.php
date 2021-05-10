<?php

namespace App\Http\Resources\Chat;

use Illuminate\Http\Resources\Json\JsonResource;
use Storage;
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
        // return [
        //     "id"        =>  $this->id,
        //     "user"      => [
        //         "id"    => $this->$user->id,
        //         "type"  => $this->user_type,
        //         "name"  => $this->$user->name,
        //         "image" => $this->$user->image ? \Storage::disk($disk)->url($this->$user->image) : null,
        //     ],
        //     "message"      =>  $this->message,
        //     "message_type" =>  $this->message_type,
        //     "seen"         =>  $this->seen,
        //     "created_at"   =>  $this->created_at->format("d-m-Y h:i:s"),
        // ];

        $message = [
            'id'           =>  $this->id,
            'user_id'      =>  $this->user_id,
            'user_type'    =>  $this->user_type,
            'message'      =>  $this->message,
            'message_type' =>  $this->message_type,
            'order_id'     =>  $this->chat->order->id,
            'time'         => \Carbon\Carbon::now(),
        ];

        if($this->user_type == "client") {
            $message['client'] = [
                "id"        => $this->client->id,
                "name"      => $this->client->name,
                "image"     => $this->client->image && $this->client->image != "" ? Storage::disk("clients")->url($this->client->image) : null,
            ];
        }else {
            $message['payer'] = [
                "id"        => $this->payer->id,
                "name"      => $this->payer->name,
                "image"     => $this->payer->image && $this->payer->image != "" ? Storage::disk("users")->url($this->payer->image) : null,
            ];
        }

        return $message;

    }
}
