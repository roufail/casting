<?php

namespace App\Notifications\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Events\Admin\OrderPaymentEvent;
class AdminPaymentNotification extends Notification
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
            'notification'     => $this->order->client->name." ".__('API/notifications.trans.make_a_payment_to')." ".$this->order->userservice->service->title." ".__('API/notifications.trans.costs')." ".$this->order->price,
            'title'            => __('API/notifications.titles.payment'),
            'not_id'           => $this->order->id,
            'not_type'         => 'order',
            'notifiable_id'    => $notifiable->id
        ];
    }


    public function toBroadcast($notifiable)
    {
        return (
            new OrderPaymentEvent($notifiable->id,__('API/notifications.titles.payment'),$this->order->client->name." ".__('API/notifications.trans.make_a_payment_to')." ".$this->order->userservice->service->title." ".__('API/notifications.trans.costs')." ".$this->order->price,$this->order->id,'order')
        );
    }

}
