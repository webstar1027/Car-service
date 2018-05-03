<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use URL;
use Session;
use Redirect;
use Mail;
use App\User;
use App\Model\Shopofinfo;
use App\Model\Shopofuser;
use App\Model\Subscriptionplan;
use Illuminate\Support\Facades\Input;
use App\Model\Billing;
use App\Mail\BillingStatus;
use Illuminate\Support\Facades\Auth;
/* All Paypal Details class */
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Refund;
use PayPal\Api\Sale;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\RefundRequest;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use App\Notifications\PaymentStatus as PaymentStatusNotification;
use App\Notifications\MaintfyPayment as MaintfyPaymentNotification;
use App\Services\NewNotifiable;
use Notification;
class PaypalController extends Controller
{
    //
    protected $newnotifiable;
 
    public function __construct(NewNotifiable $newnotifiable)
    {
        $this->newnotifiable = $newnotifiable;
      
    }
    private function paypal()
    {
        $paypal = new ApiContext( 
            new OAuthTokenCredential( 
                'AQgrgFqLopDxEGvpaUeQCGYtt1ZIdsjfVI5mKanv41hZqdaGz1jjosaiHAxhVLKVkW1v9_0dDitEnlOL', //client ID
                'ELM2iIRWu7IbTP_8s1WzgddhmXz3bJYrHhV8HiIMeO4tdhb2IrugVZTkL3KwXvXmu-rkDQm6Iw1VXAAj' //secrit ID
                ));
        return $paypal;
    }  
    /**
     * Store a details of payment with paypal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postPaymentWithpaypal(Request $request)
    {
        $shopid = Shopofuser::where('user_id', Auth::user()->id)->first()->shopofinfo_id;
    	$plan_type = $request->plantype;     
       
     
        if( $plan_type == 'add' || $plan_type == 'renew') {
          $plan_amount = intval($request->amount) + intval($request->amount)*0.095;  
        
        }
        if($plan_type == 'upgrade'){          
          
           $plan = Subscriptionplan::where('shopofinfo_id', $shopid)->first();
           $credit = (Billing::getMonths($plan['end_date'])/12 )*(intval($plan['subscription_plan']))* (1+0.1);
           $plan_amount =  intval($request->amount) + intval($request->amount)*0.095 - $credit;    
        }  

        if($plan_type == 'downgrade') {
             $plan = Subscriptionplan::where('shopofinfo_id', $shopid)->first();
             $credit = (Billing::getMonths($plan['end_date'])/12 )*(intval($plan['subscription_plan']))* (1+0.1);
             $plan_amount =  intval($request->amount) + intval($request->amount)*0.095 - $credit; 
             $paymentid = Billing::where('shopofinfo_id', $shopid)->where('charge_type', 1)->orderBy('created_at', 'desc')->first()->sale_id;
             $payment = Payment::get($paymentid, $this->paypal());
             $transactions = $payment->getTransactions();
          
             $resources = $transactions[0]->getRelatedResources();//This DOESN'T work for PayPal transactions.

             $sale = $resources[0]->getSale();
             $saleID = $sale->getId();
              
             $oldplan =  Billing::where('shopofinfo_id', $shopid)
                       ->where('charge_type', 1)
                       ->orderBy('created_at', 'desc')->first();           
             $refund_amount = abs($plan_amount);
             $percent = floatval($refund_amount)/floatval($oldplan['charge_value']);
             session()->put('refund_amount', $refund_amount);
             $amt = new Amount();
             $amt->setTotal($percent)
                  ->setCurrency('USD');

             $refund = new Refund();
             $refund->setAmount($amt);
             
             $sale = new Sale();
             $sale->setId( $saleID);
             try {
                // Create a new apiContext object so we send a new
                // PayPal-Request-Id (idempotency) header for this resource
                $paypal = $this->paypal();               
                // Refund the sale
                // (See bootstrap.php for more on `ApiContext`)
                $sale->refund($refund,$this->paypal());

                /*
                 *  Adjustment Entry 
                 */
                
                $shopinfo = Shopofinfo::where('id', $shopid)->first();
                $charge_value = floatval($oldplan['charge_value'])- floatval($refund_amount);
                Billing::insert('downgrade', $shopid, $charge_value, $paymentid);
                Subscriptionplan::where('shopofinfo_id', $shopid)->update([
                    'subscription_plan' => $request->amount,
                    'start_date' => date('Y-m-d', strtotime('now')),
                    'end_date' => date('Y-m-d', strtotime('+12 months', strtotime('now'))),
                    'status' => 0,
                    'updated_at' => date('Y-m-d H:i:s', strtotime('now'))
                ]);
                session()->put('refund', 'Refund Success');
                $mail = array(
                    'amount' => $request->amount,
                    'plantype' => 'Downgrade',
                    'shopinfo' => $shopinfo
                );                
                session()->put('add_mail', $mail);
                Mail::to('billing@maintfy.com')->send(new BillingStatus( $mail)); 
                /*
                 * Notification send.
                 */
                $user = User::where('id', Auth::user()->id)->first();
                $user->notify(new PaymentStatusNotification($plan_type, $request->amount, $refund_amount));

                $shopinfo = Shopofinfo::where('id', Shopofuser::where('user_id', $user['id'])->first()->shopofinfo_id)->first();
               (new NewNotifiable('notifications@maintfy.com'))->notify(new MaintfyPaymentNotification($shopinfo, $plan_type, $request->amount, $refund_amount));
                return redirect('/shop/subscription');
            } catch (PayPal\Exception\PayPalConnectionException $ex) {
                  echo $ex->getCode();
                  echo $ex->getData();
                  die($ex);
            } catch (Exception $ex) {
              die($ex);
            }
           }          
        
        session()->put('plantype', $plan_type);
        session()->put('planamount', $request->amount);
        session()->put('amount', $plan_amount);
    	$paypal = $this->paypal();


        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item_1 = new Item();
        $item_1->setName('Business') /* item name */
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($plan_amount); /* unit price */

        $item_list = new ItemList();
        $item_list->setItems(array($item_1));

        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($plan_amount);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Your transaction description');


        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('payment.status')) /* Specify return URL */
            ->setCancelUrl(URL::route('payment.status'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
            /* dd($payment->create($paypal));exit; */
        try {
            $payment->create($paypal);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                \Session::put('error','Connection timeout');
                return redirect('/shop/subscription');
             
            } else {
                \Session::put('error','Some error occur, sorry for inconvenient');
                return redirect('/shop/subscription');
                /* die('Some error occur, sorry for inconvenient'); */
            }
        }
        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

      
        Session::put('paypal_payment_id', $payment->getId());
        if(isset($redirect_url)) {
          
            return Redirect::away($redirect_url);
        }
        \Session::put('error','Unknown error occurred');
        return redirect('/shop/subscription');
    }
    public function getPaymentStatus()
    {
    	$paypal = $this->paypal();
        /* Get the payment ID before session clear */
        $payment_id = Session::get('paypal_payment_id');
        /* clear the session payment ID */
        Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            \Session::put('error','Payment failed');
            return redirect('/shop/subscription');
        }
        $payment = Payment::get($payment_id, $paypal);       
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
        /**Execute the payment **/
        $result = $payment->execute($execution, $paypal);
        /* dd($result);exit; /* DEBUG RESULT, remove it later **/
        if ($result->getState() == 'approved') {             
                   
            $shopid = Shopofuser::where('user_id', Auth::user()->id)->first()->shopofinfo_id;
            $shopinfo = Shopofinfo::where('id', $shopid)->first();
            $mail = array(
                    'amount' => session()->get('planamount'),
                    'plantype' => session()->get('plantype'),
                    'shopinfo' => $shopinfo
            );   
           
            session()->put('add_mail', $mail);
            Mail::to('billing@maintfy.com')->send(new BillingStatus( $mail)); 
            Billing::insert(session()->get('plantype'), $shopid, session()->get('planamount'), $payment_id);

            $user = User::where('id', Auth::user()->id)->first();
            $user->notify(new PaymentStatusNotification(session()->get('plantype'), session()->get('planamount'), session()->get('amount')));
            (new NewNotifiable('notifications@maintfy.com'))->notify( new MaintfyPaymentNotification($shopinfo, session()->get('plantype'), session()->get('planamount'), session()->get('amount')));
            if (session()->get('plantype') == 'add') {             
                Subscriptionplan::insert($shopid, session()->get('planamount'));               
            }
            if(session()->get('plantype') == 'upgrade'){              
                Subscriptionplan::where('shopofinfo_id', $shopid)->update([
                    'subscription_plan' => session()->get('planamount'),
                    'start_date' => date('Y-m-d', strtotime('now')),
                    'end_date' => date('Y-m-d', strtotime('+12 months', strtotime('now'))),
                    'status' => 0,
                    'updated_at' => date('Y-m-d H:i:s', strtotime('now'))
                ]);
            }
            if(session()->get('plantype') == 'renew') {
                 Subscriptionplan::where('shopofinfo_id', $shopid)->update([
                    'start_date' => date('Y-m-d', strtotime('now')),
                    'end_date' => date('Y-m-d', strtotime('+12 months', strtotime('now'))),
                    'status' => 0,
                    'updated_at' => date('Y-m-d H:i:s', strtotime('now'))
                  ]);

            }
            session()->forget('plantype');
            session()->forget('planamount');
            \Session::put('success','Payment success');
            return redirect('/shop/subscription');
        }
        \Session::put('error','Payment failed');
        return redirect('/shop/subscription');
    }
   
 
}
