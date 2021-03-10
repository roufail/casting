<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'id'          => $this->id,
            'client'      => $this->whenLoaded('client'),
            'user'        => $this->whenLoaded('user'),
            'userservice' => $this->when(
                $this->relationLoaded('userservice') &&
                $this->userservice->relationLoaded('service'),
                function () {
                    return [
                        "title" => $this->userservice->service->title
                    ];
                }
            ),
            'status'      => $this->status,
            "price"       => $this->price,
        ];
    }
}
