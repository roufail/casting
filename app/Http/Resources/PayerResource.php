<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Service\ServiceResource;

class PayerResource extends JsonResource
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
            "image"          => $this->image ? \Storage::disk("users")->url($this->image) : null,
            "name"           => $this->name,
            "active"         => $this->active,
            "payer_data"     => new PayerDataResource($this->payer_data),
            "video_url"      => new PayerVideoResource($this->whenLoaded("work_video")), 
            "images_urls"    => new PayerImagesCollection($this->work_images()->paginate(1)), 
            "rating"         => $this->rating_stars(),
            "firebase_token" => $this->firebase_token,
            "age"            => date_diff(date_create($this->dob), date_create('now'))->y,
            //"services"     => ServiceResource::collection($this->services()->where("active",1)->get()),
            "services"       => ServiceResource::collection($this->whenLoaded("services")),
            "services_count" => $this->whereHas("orders",function($orders){
                $orders->where('status','done')->where('user_id',$this->id);
            })->count(),
        ];
    }
}
