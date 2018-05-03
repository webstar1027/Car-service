<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ServiceStatusChange extends Notification
{
    use Queueable;
    private $actionname;
    private $master;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($actionname, $master)
    {
        //
        $this->actionname = $actionname;
        $this->master = $master;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
                    ->subject('Service Action Status Change Here')
                    ->line('You are receiving this mail because you are change service status.')
                    ->line('Action name: '.$this->actionname)
                    ->line('Service name: '.$this->master['master_service_name'])
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
            //
        ];
    }
}
