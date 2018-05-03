<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Subscriptionplan extends Model
{
    //
    protected $table = 'subscriptionplans';
    protected $fillable = [
    	'shopofinfo_id', 'subscription_plan', 'start_date', 'end_date', 'status'
    ];

    public static function insert ($shopid, $plan) {

    	$subscription = new Subscriptionplan;
        $subscription->shopofinfo_id = $shopid;
        $subscription->subscription_plan =  $plan;
        $subscription->start_date = date('Y-m-d', strtotime('now'));
        $subscription->end_date = date('Y-m-d', strtotime('+12 months', strtotime('now')));
        $subscription->status = 0;
        $subscription->save();
        
    }
}
