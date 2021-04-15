<?php

namespace App\Http\Resources\Service;
use App\Http\Resources\Service\RatingResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PayerResource;
use  App\Http\Resources\MainService\MainServiceResource;
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
            'user_id'       => $this->user_id,
            'service_price' => (double)$this->price,
            'work_type'     => $this->work_type,
            'category_id'   => $this->service->category->id,
            'category'      => $this->service->category->title,
            'payer'         => $this->when($this->load_payer || !isset($this->load_payer),new PayerResource($this->whenLoaded('user'))),
            'main_service'  => new MainServiceResource($this->service),
        ];
    }
}
