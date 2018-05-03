<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MaintfyPayment extends Notification
{
    use Queueable;
    private $shop;
    private $plantype;
    private $amount;
    private $planamount;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($shop, $plantype, $amount, $planamount)
    {
        //
        $this->shop = $shop;
        $this->plantype = $plantype;
        $this->amount = $amount;
        $this->planamount = $planamount;
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
        if($this->amount == '480'){
            $planname = 'California Listings with Scheduling Plan  $480 per Year';
        }
        else{
            $planname = 'California Listing only Plan  $120 per Year';
        }
        return (new MailMessage)
                ->subject('Shopowner Plan Change Notification')
                ->line('Maintfy administrator are receiving this email because shopowner changeed his subscription plan.')
                ->line('Shop Name: '.$this->shop['shop_name'])
                ->line('Subscription plan: '.$planname)
                ->line('Plan type: '.$this->plantype)
                ->line('Billing amount: $'.$this->planamount)
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
