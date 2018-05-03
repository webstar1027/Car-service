<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BillingStatus extends Mailable
{
    use Queueable, SerializesModels;
    protected $plan;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($plan)
    {
        //
        $this->plan = $plan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('shopid #'.$this->plan['shopinfo']['id'].' plan changes  Shopname:'.$this->plan['shopinfo']['shop_name'])             
             ->view('pages.email.billing')->with(['planamount' => $this->plan['amount'], 'plan_change_type' => $this->plan['plantype']]);
    }
}
