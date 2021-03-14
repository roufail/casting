<?php

namespace App\Events\Service;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PayerRequestEvent implements ShouldBroadcast
{
    public $data;

    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($notifiable_id,$notification,$service_id,$type)
    {
        $this->data['object_id']     = $notifiable_id;
        $this->data['notification']  = $notification;
        $this->data['not_id']        = $service_id;
        $this->data['not_type']      = $type;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('payer.'.$notifiable_id);
    }

    public function broadcastAs()
    {
        return 'notification';
    }

}
