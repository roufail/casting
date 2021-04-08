<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PayerResource;
use App\Http\Resources\ClientResource;
class OrderResource extends JsonResource
{


    public static $mode = 'single';

    /**
     * Set the current mode for this resource.
     * @param $mode
     */
    public static function setMode($mode)
    {
        self::$mode = $mode;
        return __CLASS__;
    }



    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $result =  [
            'id'          => $this->id,
            'client'      => new ClientResource($this->whenLoaded('client')),
            'payer'       => new PayerResource($this->whenLoaded('user')),
            // 'service'     => $this->userservice,
            'service'     => $this->when(
                $this->relationLoaded('userservice') &&
                $this->userservice->relationLoaded('service'),
                function () {
                    return [
                        "id"        => $this->userservice->id,
                        "title"     => $this->userservice->service->title,
                        "work_type" => $this->userservice->work_type,
                        "price"     => $this->price,
                        "image"     => $this->userservice->service->image ? \Storage::disk('services')->url($this->userservice->service->image) : null,
                    ];
                }
            ),
            'status'         => $this->status,
            'price'          => $this->price,
            'created_at'     => $this->created_at,
            'payment_method' => 'Cash' 
        ];

        if(self::$mode == "single"){
            $result['updated_at']     = $this->updated_at;
        }

        return $result;


    }
}
