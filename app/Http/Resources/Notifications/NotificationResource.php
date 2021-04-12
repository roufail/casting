<?php

namespace App\Http\Resources\Notifications;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $class_name      = isset($this['data']['reported_type']) ? ucfirst($this['data']['reported_type']) : 'Client';
        $class = 'App\\Models\\' . $class_name;
        $reported        = $class::find($this['data']['reported_id']);
        return [
            "id"             => $this->id,
            "title"          => isset($this['data']['title']) ? $this['data']['title'] : '' ,
            "notification"   => isset($this['data']['notification']) ? $this['data']['notification'] : '',
            "type"           => isset($this['data']['not_type']) ? $this['data']['not_type'] : '',
            "read_at"        => $this->read_at,
            "created_at"     => $this->created_at,
            "reported"       => [ 
                'id'    => isset($this['data']['reported_id']) ? $this['data']['reported_id'] : '',
                'type'  => isset($this['data']['reported_type']) ? $this['data']['reported_type'] : '',
                'name'  => $reported->name,
                'image' => $reported->image ? \Storage::disk($this['data']['reported_type']."s")->url($reported->image) : null,
            ]
        ];
    }
}