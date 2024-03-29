<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PayerResource;
use App\Http\Resources\ClientResource;



class OrderResource extends JsonResource
{
    private $status_ar = ['paid', 'processing', 'cancelled', 'done','pending','failed','received'];


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
            'status'         => ['index' => array_search($this->status,$this->status_ar) , 'string' => $this->status],
            'price'          => $this->price,
            'created_at'     => $this->created_at,
            'payment_method' => 'Cash' 
        ];

        if(self::$mode == "single"){
            $result['updated_at']     = $this->updated_at;
            $result['service'] = [
                'id' => $this->userservice->id,
                'title' => $this->userservice->service->title,
                'price' => $this->userservice->price,
                'work_type' => $this->userservice->work_type,
            ];
            $result['rated'] = $this->userservice->ratings->count() > 0 ? true : false;
        }elseif($this->load_payer || !isset($this->load_payer)){
            $result['payer'] = [
                'id'     => $this->user->id,
                'name'   => $this->user->name,
                'email'  => $this->user->email,
                'image'  => $this->user->image ? \Storage::disk('users')->url($this->user->image) : null,
                'rating' => $this->user->rating_stars()
	        ];
        } else {
            $result['client'] = [
                'id' => $this->client->id,
                'name' => $this->client->name,
                'image' => $this->client->image ? \Storage::disk('clients')->url($this->client->image) : null
            ];
        }

        return $result;

    }
}
