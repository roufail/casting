<?php

namespace App\Notifications\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Events\Admin\RequestPaymentEvent;

class PaymentRequestNotification extends Notification
{
    use Queueable;
    private $payment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($payment)
    {
        $this->payment = $payment;
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
            'notification'     => $this->payment->user->name." ".__('API/notifications.trans.asked_for_payment_request'),
            'title'            => __('API/notifications.titles.payment_request'),
            'not_id'           => $this->payment->id,
            'not_type'         => 'payment_request',
            'notifiable_id'    => $notifiable->id
        ];
    }


    public function toBroadcast($notifiable)
    {
        return (
            new RequestPaymentEvent($notifiable->id, __('API/notifications.titles.payment_request'), $this->payment->user->name." ".__('API/notifications.trans.asked_for_payment_request'),$this->payment->id,'payment_request')
        );
    }


}
