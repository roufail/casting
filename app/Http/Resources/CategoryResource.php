<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Service\ServiceCollection;
class CategoryResource extends JsonResource
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
            "id"       => $this->id,
            "title"    => $this->title,
            "image"    => $this->image ? \Storage::disk("categories")->url($this->image) : null,
            "services" => $this->when($this->load_services , new ServiceCollection($this->services()->paginate(15))),
        ];
    }
}
