<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Message implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public  $data = [];
    private $order_id,$type;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($notifiable_id,$message,$order_id,$type)
    {
        $this->order_id                  = $order_id;
        $this->type                      = $type;
        $this->data['notifiable_id']     = $notifiable_id;
        $this->data['message']           = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chat-channel.'.$this->type.'.'.$this->data['notifiable_id']);
    }

    public function broadcastAs()
    {
        return 'message';
    }

}
