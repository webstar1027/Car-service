<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ShopownerBook extends Notification
{
    use Queueable;
    private $shop;
    private $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($shop, $user)
    {
        //
        $this->shop = $shop;
        $this->user = $user;
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
                    ->subject('Maintfy Shopowner Service Book Appointment Here')
                    ->line('You are receiving this email because you receive appointment request from '.$this->user['firstname'].' '.$this->user['lastname'].' for '.$this->shop['category_name'].' for '.$this->shop['year'].' '.$this->shop['make'].' '.$this->shop['model'].' '.$this->shop['term'].' car.')                    
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
