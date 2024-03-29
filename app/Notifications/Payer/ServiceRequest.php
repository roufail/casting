<?php

namespace App\Notifications\Payer;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Events\Service\PayerRequestEvent;

use Benwilkins\FCM\FcmMessage;


class ServiceRequest extends Notification implements ShouldQueue
{
    use Queueable;
    public $client,$user,$service;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($client,$service)
    {
        $this->client  = $client;
        $this->service = $service;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['fcm','database','broadcast','mail'];
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
            'notification'     => $this->client->name." ".__('API/notifications.trans.asked_for')." ".$this->service->title,
            'title'            => __('API/notifications.titles.new_service_request'),
            'not_id'           => $this->service->id,
            'not_type'         => 'service',
            'notifiable_id'    => $notifiable->id,
            'reported_id'      => $this->client->id,
            'reported_type'    => 'client'
        ];
    }


    public function toFcm($notifiable) {
        $message = new FcmMessage();
        $message->content([
            'title'        => __('API/notifications.titles.new_service_request'), 
            'body'         => $this->client->name." ".__('API/notifications.trans.asked_for')." ".$this->service->title, 
        ]);
        return $message;
    }
    

    public function toBroadcast($notifiable)
    {
        return (new PayerRequestEvent($notifiable->id,__('API/notifications.titles.new_service_request'),$this->client->name." ".__('API/notifications.trans.asked_for')." ".$this->service->title,$this->service->id,'service'));
    }





}
