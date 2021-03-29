<?php

namespace App\Http\Resources\Service;
use App\Http\Resources\Service\RatingResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PayerResource;
class ServiceResource extends JsonResource
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
            'id'            => $this->id,
            'title'         => $this->service->title,
            'min_price'     => $this->user->services()->min("price"),
            'service_price' => $this->price,
            'work_type'     => $this->work_type,
            'category_id'   => $this->service->category_id,
            'payer'         => new PayerResource($this->whenLoaded('user')),
        ];
    }
}
