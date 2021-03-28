<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PayerDataResource extends JsonResource
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
            "job_title"  => $this->job_title,
            "prev_work"  => $this->prev_work,
            "bio"        => $this->bio,
        ];
    }
}
