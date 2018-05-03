<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Shopofuser;
use App\Model\Subscriptionplan;
use Illuminate\Support\Facades\Auth;
class Billing extends Model
{
    //

     protected $table ='billings';
     protected $fillable = ['shopofinfo_id','transaction_date','plan_change_type', 'transaction_description', 'charge_value', 'charge_type', 'charge_method'];

     public static function insert($type, $id, $amount, $sale_id) {

     
     	if ($type == 'add') { 

        $tax_price = 0.095*intval($amount);    		
        $total_price = intval($amount) + $tax_price;
    
     		$billing = new Billing;
     		$billing->shopofinfo_id = $id;
     		$billing->transaction_date = date('Y-m-d', strtotime('now'));
     		$billing->plan_change_type = 0;
     		$billing->transaction_description = 'Added California Listing Subscription Plan $'.$amount.' per Year  Price: $'.$total_price.' including $'.$tax_price.' taxes ';
     		$billing->charge_value = $total_price;
     		$billing->charge_type = 1;
     		$billing->charge_method = 'paypal';
        $billing->sale_id = $sale_id;
     		$billing->save();

        echo "this is ok test";

     	}

      if($type == 'upgrade') {
        $tax_price = 0.095*intval($amount);        
        $total_price = intval($amount) + $tax_price;

        $shopid = Shopofuser::where('user_id', Auth::user()->id)->first()->shopofinfo_id;
        $plan = Subscriptionplan::where('shopofinfo_id', $shopid)->first();
        $credit = (Billing::getMonths($plan['end_date'])/12 )*(intval($plan['subscription_plan']))* (1+0.1);
        $billing = new Billing;
        $billing->shopofinfo_id = $id;
        $billing->transaction_date = date('Y-m-d', strtotime('now'));
        $billing->plan_change_type = 2;
        $billing->transaction_description = 'Adjustment of $'.$credit.' (to add tax rate of 10 percent) including taxes for removing plan $'. $plan['subscription_plan'] ;
        $billing->charge_value =  $credit;
        $billing->charge_type = 0;
        $billing->charge_method = 'Maintfy Account';
        $billing->save();
        
        $billing = new Billing;
        $billing->shopofinfo_id = $id;
        $billing->transaction_date = date('Y-m-d', strtotime('now'));
        $billing->plan_change_type = 2;
        $billing->transaction_description = 'Added California Listing Subscription Plan $'.$amount.' per Year  Price: $'.($total_price-$credit).' including $'.$tax_price.' taxes ';
        $billing->charge_value = intval($amount) + 0.095*intval($amount)-$credit;
        $billing->charge_type = 1;
        $billing->charge_method = 'paypal';
        $billing->sale_id = $sale_id;
        $billing->save();


      }
      if ($type == 'renew') {     
        $tax_price = 1.1*intval($amount);        
        $total_price = intval($amount) + $tax_price;    

        $shopid = Shopofuser::where('user_id', Auth::user()->id)->first()->shopofinfo_id;
        $plan = Subscriptionplan::where('shopofinfo_id', $shopid)->first();
        $billing = new Billing;
        $billing->shopofinfo_id = $id;
        $billing->transaction_date = date('Y-m-d', strtotime('now'));
        $billing->plan_change_type = 1;
        $billing->transaction_description = 'Renewed Existing Plan $'. $plan['subscription_plan'].',  with old end date '.$plan['end_date'].', now renewed to '.date('Y-m-d', strtotime('now')).' New Plan Charge $'.$total_price.', Tax Charges of $'.$tax_price; 
        $billing->charge_value = $total_price;
        $billing->charge_type = 1;
        $billing->charge_method = 'paypal';
        $billing->sale_id = $sale_id;
        $billing->save();

      }

      if($type == 'downgrade') {
        $shopid = Shopofuser::where('user_id', Auth::user()->id)->first()->shopofinfo_id;
        $plan = Subscriptionplan::where('shopofinfo_id', $shopid)->first();
        $refund_amount = session()->get('refund_amount');
        session()->forget('refund_amount');
        $billing = new Billing;         
        $billing->shopofinfo_id = $id;
        $billing->transaction_date = date('Y-m-d', strtotime('now'));
        $billing->plan_change_type = 3;
        $billing->transaction_description = 'Downgrade from Existing Plan $'. $plan['subscription_plan'].' to $120 plan by refunding $'.$refund_amount; 
        $billing->charge_value = $amount;
        $billing->charge_type = 0;
        $billing->charge_method = 'paypal';
        $billing->sale_id = $sale_id;
        $billing->save();

      }

     }

     public static function getMonths($date){
         $current_date = date('Y-m-d', strtotime('now'));

         $ts1 = strtotime($current_date);
         $ts2 = strtotime($date);

         $year1 = date('Y', $ts1);
         $year2 = date('Y', $ts2);

         $month1 = date('m', $ts1);
         $month2 = date('m', $ts2);

         $diff = (($year2 - $year1) * 12) + ($month2 - $month1);

         return $diff;
     }
}
