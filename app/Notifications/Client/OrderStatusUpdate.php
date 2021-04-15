<?php

namespace App\Notifications\Client;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Events\Client\OrderStatusUpdateEvent;

class OrderStatusUpdate extends Notification
{
    use Queueable;
    private $order;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast','mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'notification'     => $this->order->user->name." ".lang('API.notifications.trans.changed_your_order')." ".$this->order->userservice->service->name." ".lang('API.notifications.trans.status_to')." ".lang('API.notifications.status.'.$this->order->status),
            'title'            => lang('API.notifications.titles.order_status_changed'),
            'not_id'           => $this->order->id,
            'not_type'         => 'order',
            'notifiable_id'    => $notifiable->id,
            'reported_id'      => $this->order->client->id,
            'reported_type'    => 'client'
        ];
    }


    public function toBroadcast($notifiable)
    {
        return (
            new OrderStatusUpdateEvent($notifiable->id,
            lang('API.notifications.titles.order_status_changed'),
            $this->order->user->name." ".lang('API.notifications.trans.changed_your_order')." ".$this->order->userservice->service->name." ".lang('API.notifications.trans.status_to')." ".lang('API.notifications.status.'.$this->order->status),
            $this->order->id
           ,
           'order'));
    }


}
