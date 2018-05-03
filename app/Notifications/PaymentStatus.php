<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentStatus extends Notification
{
    use Queueable;
    private $planamount;
    private $plantype;
    private $amount;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($plantype, $amount, $planamount)
    {
        //
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
                ->subject("Shopowner subscription plan change Here")
                ->line('You are receiving this email because you are changing your plan.')
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
