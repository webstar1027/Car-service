<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CarService extends Notification
{
    use Queueable;
    private $car;
    private $servicename;
    private $carinfo;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($car, $name, $info)
    {
        //
        $this->car = $car;
        $this->servicename = $name;
        $this->carinfo = $info;
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
                ->subject('Your car service notification Here')
                ->line('You are receving this email because you enabled car service notification when you create Maintfy account car.')
                ->line('Car Name: '.$this->car['description_name'])
                ->line('Service : '.$this->servicename)
                ->line('Car info: '.$this->carinfo['year'].' '.$this->carinfo['make'].' '.$this->carinfo['model'].' '.$this->carinfo['term'])
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
