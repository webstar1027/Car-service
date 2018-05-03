<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\Car;
use App\Model\Category;
use App\Model\Serviceofcar;
use App\Model\Shopofinfo;
use App\Model\Shopofuser;
use App\Model\Service;
use App\Model\Serviceofshop;
use App\Model\Master;
use App\Model\Masterserviceofshop;
use App\Model\Price;
use App\Model\Pricetype;
use App\Model\Userofcar;
use App\Model\Shophour;
use App\Model\Notification;
use App\Model\NotificationType;
use App\Model\Event;
use App\Model\Rate;
use Carbon\Carbon;
use App\Model\RoleUser;
use App\Model\File;
use App\User;
use App\Model\Subscriptionplan;
use DateTime;
use App\Notifications\UserRate as UserRateNotification;
use App\Notifications\ShopownerRate as ShopownerRateNotification;
class UserController extends Controller
{
    //
    public function showAdmin(){
        $cars = Car::all();
        $categorys = Category::findMainCategory();
        $services = Category::all();

        $shopofnfos = Shopofinfo::all();
        $data = array(
            'cars' => $cars,
            'categorys' => $categorys,
            'services'  => $services,
            'shops'     => $shopofnfos
        );
    	return View('pages.admin')->with($data);
    }

    public function showShopOwner(Request $request){
        /**
         *   clear all session data
         */
      
        $id = Auth::user()->id;
        $services = Shopofuser::where('shopofusers.user_id', '=',  $id)
                              ->join('serviceofshops', 'shopofusers.shopofinfo_id', 'serviceofshops.shopofinfos_id')
                              ->join('masterserviceofshops', 'serviceofshops.serviceofshop_id', 'masterserviceofshops.serviceofshop_id')
                              ->join('masters', 'masterserviceofshops.master_id', 'masters.master_id')->get();
       
       
        $master_service_data = array();
        $active_number = 0;
        $expire_number = 0;
        $deactive_number = 0;
        $master_id = array();
        foreach($services as $item) {            
            if(!in_array($item['master_id'], $master_id)) array_push($master_id, $item['master_id']);
        }
        foreach($master_id as $item1){
           $master =  Masterserviceofshop::where('master_id', $item1)->get();
           foreach($master as $item2) {
             switch($item2['status']) {
                case 0:
                  $active_number++;
                  break;
                case 1:
                  $expire_number++;
                  break;
                case 2:
                  $deactive_number++;
                  break;
             }
           }
           $master_service_name = Master::where('master_id', $item1)->first();
           $data = array(
             'id' => $master_service_name->master_id,
             'masterservice_name' => $master_service_name->master_service_name,
             'active_number' => $active_number,
             'deactive_number' => $deactive_number,
             'expire_number'  => $expire_number,
             'created_date'   => date('Y-m-d', strtotime($master_service_name->created_at))
           );
            $active_number = 0;
            $expire_number = 0;
            $deactive_number = 0;
           array_push($master_service_data, $data);

        }

        /*
         *  shopowner business license verify
         */
        $insurance_status = false;
        $license_status = false;
        $payment_status = false;
        $upload_status = false;
        $file = File::where('user_id', $id)->get();
        if(count($file) > 0) {
          foreach($file as $item3) {
            if($item3['file_type'] == 0) {
                if($item3['status'] == 1){
                    $insurance_status = true;
                }
            }
            if($item3['file_type'] == 1) {
                if($item3['status'] == 1){
                    $license_status = true;
                }
            }
          }
        }
        else{
          $upload_status = true;
        }

        $shopid = Shopofuser::where('user_id', $id)->first()->shopofinfo_id;
        $subscription_plan = Subscriptionplan::where('shopofinfo_id', $shopid)->first();
        if(isset($subscription_plan)) {
          if ($subscription_plan['status'] == 0) {
            $payment_status = true;
          }    
        }
        else{
           $payment_status = 'noregister';
        }
        $shopofinfo = Shopofinfo::where('id', $shopid)->first();

        if ( $shopofinfo['barnumber_valid'] == 1 && $shopofinfo['epanumber_valid'] == 1) $number_valid = true; else $number_valid = false;
        $send_data = array(
            'insurance_status' => $insurance_status,
            'license_status' => $license_status,
            'payment_status' => $payment_status,
            'master_service_data' => $master_service_data,
            'upload_status' => $upload_status,
            'number_valid' => $number_valid
        );    
       
    	return View('pages.shopowner')->with($send_data);
        // return json_encode($master_id);
        // exit;   
    	
    }

    public function showUser(){

        $categorys = Category::findMainCategory();
        $user_id = Auth::user()->id;
        $usercars = Userofcar::where('user_id', $user_id)
                             ->join('cars', 'userofcars.car_id', 'cars.id')->get();
        $data = array(
            'categorys' => $categorys,
            'usercars'  => $usercars
        );
    	return View('pages.user')->with($data);
        //return json_encode($usercars);
    	
    }

    public function goBack() {
        return redirect('/user');
    }

    /*
     -----------------------------------------------------------------------------------
     |  Display detail view for selected master service                                 |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       master service id : int                                                    |
     | @return                                                                          |
     |       view                                                                       |
     -----------------------------------------------------------------------------------
     */
     public function detailMaster($id) {

         $master_id  = $id;
         $masterservice = Masterserviceofshop::where('master_id', $master_id)->first();     
         $masterservice_name = Master::where('master_id', $master_id)->first()->master_service_name;   
         $lineitems = Price::where('serviceofshop_id','=', $masterservice['serviceofshop_id'])
                            ->join('pricetypes', 'prices.pricetype_id', 'pricetypes.pricetype_id')
                            ->join('querys', 'prices.query_id', 'querys.query_id')->get();
         $items = array();
         foreach($lineitems as $item){
            array_push($items, $item['pricetype_name']);
         }        

         $childservices = Masterserviceofshop::where('master_id', '=', $master_id)                              
                                             ->leftjoin('serviceofshops', 'masterserviceofshops.serviceofshop_id', 'serviceofshops.serviceofshop_id')
                                             ->leftjoin('serviceofcars', 'serviceofshops.serviceofcar_id', 'serviceofcars.id')
                                             ->leftjoin('cars', 'serviceofcars.car_id', 'cars.id')
                                             ->leftjoin('services', 'serviceofcars.service_id', 'services.id')
                                             ->leftjoin('categorys', 'services.category_id', 'categorys.id')->get();
         $childitems = Masterserviceofshop::where('master_id', '=', $master_id)->get();
         $child_price = array();        
         foreach($childitems as $childitem){
            $item_price = array();
            $serviceofshop_id = $childitem->serviceofshop_id;
            $prices = Price::where('serviceofshop_id', $serviceofshop_id)->get();
            foreach($prices as $price){
                array_push($item_price, $price->price);
            }
            array_push($child_price, $item_price);

         }
         /**
          *   line item name get
          */

         $shopservice_id = Masterserviceofshop::where('master_id', '=', $master_id)->first()->serviceofshop_id;
         $lineitem_prices = Price::where('serviceofshop_id', $shopservice_id)->get();
         $line_name = array();
         foreach($lineitem_prices as $itemtype){
             $pricetype_name = Pricetype::where('pricetype_id', $itemtype->pricetype_id)->first()->pricetype_name;
             array_push($line_name, $pricetype_name);
         }
         
         $service_data = array(
            'masterservice_name' => $masterservice_name,
            'items' => $child_price,
            'childservices' => $childservices,
            'line_name' => $line_name,
            'id' => $id,
            'line_items' => $lineitems
         );
         return View('partial.masterdetail')->with($service_data);
         //return json_encode($childservices);
     }
     /*
      *   user main page
      */
     public function showUserMain(){
        return view('pages.usermain');
     }
     /*
      *  Mycar page transition
      */
     public function myCar () {
        $user_id = Auth::user()->id;
        $userprofiles = Userofcar::where('user_id', $user_id)
                                 ->join('cars', 'userofcars.car_id', 'cars.id')->get();
        $data = array(
            'profiles' => $userprofiles
        );

        return View('pages.userpage.mycar')->with($data);   
     }
     /*
      *  Scheduled Service page transition
      */
     public function scheduleService () {
        $user_id = Auth::user()->id;
        $events_array = Event::where('user_id', $user_id)->get();
        $send_data = array();
        foreach($events_array as $event) {
            $currentdate = date('Y-m-d h:i A', strtotime('now'));
            $compareday = date('Y-m-d h:i A', strtotime($event['start_time']));
            if($currentdate < $compareday) {
              $car = Car::where('id', $event['car_id'])->first();
              $year = $car['year'];
              $make = $car['make'];
              $model = $car['model'];
              $term = $car['term'];
              $description_name = Userofcar::where('car_id', $event['car_id'])
                                           ->where('user_id', $user_id)->first()->description_name;
              $category_id = Category::where('category_name', $event['event_name'])->first()->id;
              $service_id = Service::where('category_id', $category_id)->first()->id;
              $serviceofcar_id = Serviceofcar::where('car_id', $event['car_id'])
                                        ->where('service_id', $service_id)->first()->id;
              $serviceofshop = Serviceofshop::where('serviceofcar_id', $serviceofcar_id)->first();
              $shop_name = Shopofinfo::where('id', $event['shop_id'])->first()->shop_name;
              $event_data = array(
                  'event_id' => $event['id'],
                  'event_name' => $event['event_name'],
                  'shop_name' => $shop_name,
                  'year' => $year,
                  'make' => $make,
                  'model' => $model,
                  'term' => $term,
                  'start_time' => $event['start_time'],
                  'description_name' => $description_name,
                  'duration' => $event['duration'],
                  'service_id' => $serviceofshop['serviceofshop_id'],
                  'shop_id' => $serviceofshop['shopofinfo_id']
              );
              array_push($send_data, $event_data);
            }
        }    
       
         $data = array(
            'event_data' => $send_data
            
         );
        return View('pages.userpage.scheduleservice')->with($data);   
     //  return json_encode($calendarevent);
        // return json_encode($events);
     }

     /*
      *   user service booking status show
      */
     public function scheduleBooking(Request $request) {

        $dto = new DateTime();  
        $week = $request->weeknumber;
        $year = 2017;
        $dto->setISODate($year, $week);
        $week_start = $dto->format('Y-m-d');
        $dto->modify('+6 days');
        $week_end = $dto->format('Y-m-d');

        $flag = false;
        $user_id = Auth::user()->id;
        $events_array = Event::where('user_id', $user_id)->get();
        $send_data = array();
        foreach($events_array as $event) {
            $starttime = date('Y-m-d', strtotime($event['start_time']));
            if( $week_start <= $starttime && $week_end >= $starttime) {
              $car = Car::where('id', $event['car_id'])->first();
              $year = $car['year'];
              $make = $car['make'];
              $model = $car['model'];
              $term = $car['term'];
              $description_name = Userofcar::where('car_id', $event['car_id'])
                                           ->where('user_id', $user_id)->first()->description_name;
              $category_id = Category::where('category_name', $event['event_name'])->first()->id;
              $service_id = Service::where('category_id', $category_id)->first()->id;
              $serviceofcar_id = Serviceofcar::where('car_id', $event['car_id'])
                                        ->where('service_id', $service_id)->first()->id;
              $serviceofshop_id = Serviceofshop::where('serviceofcar_id', $serviceofcar_id)->first()->serviceofshop_id;
              $shop_name = Shopofinfo::where('id', $event['shop_id'])->first()->shop_name;
              $event_data = array(
                  'event_id' => $event['event_id'],
                  'event_name' => $event['event_name'],
                  'shop_name' => $shop_name,
                  'year' => $year,
                  'make' => $make,
                  'model' => $model,
                  'term' => $term,
                  'start_time' => $event['start_time'],
                  'description_name' => $description_name,
                  'duration' => $event['duration'],
                  'service_id' => $serviceofshop_id
              );
              array_push($send_data, $event_data);
              $flag = true;
            }
        }     

        $data = array(
          'event_data' => $send_data,
          'option_text' => $request->option
         );
        session()->put('booking.data', $data);
     }

     public function getBooking () {
        $data = session()->get('booking.data');
        return View('pages.userpage.scheduleservice')->with($data);   
     }
     public function removeEvent ($id) {

        $event_id = $id;     
        Event::where('id', $id)->delete();
        return redirect('/schedule');
     }
     /*
      *  Rate Service experience page transition
      */
     public function rateExperience () {

        $user_id = Auth::user()->id;
        $events_array = Event::where('user_id', $user_id)->get();
        $send_data = array();
        $rate_status = NULL;
        foreach($events_array as $event) {
          $currentdate = date('Y-m-d h:i A', strtotime('now'));
          $compareday = date('Y-m-d h:i A', strtotime($event['start_time']));
          if($currentdate > $compareday) {
            $car = Car::where('id', $event['car_id'])->first();
            $year = $car['year'];
            $make = $car['make'];
            $model = $car['model'];
            $term = $car['term'];
            $description_name = Userofcar::where('car_id', $event['car_id'])
                                         ->where('user_id', $user_id)->first()->description_name;
            $category_id = Category::where('category_name', $event['event_name'])->first()->id;
            $service_id = Service::where('category_id', $category_id)->first()->id;
            $serviceofcar_id = Serviceofcar::where('car_id', $event['car_id'])
                                      ->where('service_id', $service_id)->first()->id;
            $serviceofshop_id = Serviceofshop::where('serviceofcar_id', $serviceofcar_id)->first()->serviceofshop_id;
            $rate = Rate::where('serviceofshop_id', $serviceofshop_id)->first();
            if(isset($rate['value'])) {
               $rate_status = $rate['value'];
            }        
            
            // rating
            $rating = Rate::where('serviceofshop_id', $serviceofshop_id)
                          ->where('user_id', $user_id)
                          ->where('service_date', $event['start_time'])->first();

            if(isset($rating)) {
              $rate_value = $rating['value'];
              $service_date = $rating['service_date'];
            }
            else{
              $rate_value = null;
              $service_date = null;
            }
            $shop_name = Shopofinfo::where('id', $event['shop_id'])->first()->shop_name;
            $event_data = array(
              'event_id' => $event['event_id'],
              'event_name' => $event['event_name'],
              'shop_name' => $shop_name,
              'year' => $year,
              'make' => $make,
              'model' => $model,
              'term' => $term,
              'start_time' => $event['start_time'],
              'description_name' => $description_name,
              'duration' => $event['duration'],
              'service_id' => $serviceofshop_id,
              'rating' => $rate_value,
              'service_date' => $service_date
             
            );
            array_push($send_data, $event_data);
          }
        }
        $data = array(
          'event_data' => $send_data,
          'rate' => $rate_status
            
        );
        return View('pages.userpage.rateservice')->with($data);  
      
        
     }
     /*
      *  My profile page transition
      */
     public function myProfile () {
        return view('pages.userpage.myprofile');   
     }
     /*
      *   check userprofile whether selected car exists.
      */
     public function checkUserProfile (Request $request) {
        $year = $request->year;
        $make = $request->make;
        $model = $request->model;
        $term = $request->term;
        $car_data = array(
            'year' => $year,
            'make' => $make,
            'model' => $model,
            'term' => $term
        );

        $car_id = Car::findById($car_data);
        $user_id = Auth::user()->id;
        $flag = Userofcar::findById($user_id, $car_id);
        if ($flag == true) {
           $data = array(
              'flag' => $flag,
              'car_id' => $car_id,
              'current_mileage' => Userofcar::where('car_id', $car_id)->first()->current_mileage
           );
        }
        else{
           $data = array(
              'flag' => $flag,
              'car_id' => $car_id              
           );
        }
       

        return json_encode($data);
     }

     public function addCarProfile() {
        return view('pages.userpage.addcar');
     }
     /*
      *   add car on user profile.
      */
     public function updateProfile (Request $request) {

        $status = $request->status;
        $year = $request->year;
        $make = $request->make;
        $model = $request->model;
        $term = $request->term;
        $car_data = array(
            'year' => $year,
            'make' => $make,
            'model' => $model,
            'term' => $term
        );
        $car_id = Car::findById($car_data);
        $user_id =Auth::user()->id;
        $current_mileage = $request->current_mileage;
        $annual_miles = $request->annual_miles;
        $description_name = $request->description_name;
        if($status == 1) {         
            $notification_status = $request->notification_status;
            $notification_type = $request->notification_type;
            $profile_data = array(
                'user_id' => $user_id,
                'car_id'  => $car_id,
                'current_mileage' => $current_mileage,
                'annual_miles' => $annual_miles,
                'description_name' => $description_name,
                'notification_status' => 1
            );

            $userofcar_id = Userofcar::insert($profile_data);

            for($i=0; $i<count($notification_status); $i++){
               $type_id = NotificationType::where('notification_type_name', $notification_type[$i])->first()->notification_type_id;
               $notification_data = [
                 'notification_type_id' => $type_id,
                 'userofcar_id'         => $userofcar_id,
                 'status'               => $notification_status[$i]
               ];
               Notification::insert($notification_data);
            }

        }
        else{

            $profile_data = array(
                'user_id' => $user_id,
                'car_id'  => $car_id,
                'current_mileage' => $current_mileage,
                'annual_miles' => $annual_miles,
                'description_name' => $description_name,
                'notification_status' => 0
            );
            Userofcar::insert($profile_data);

        }
        
        return redirect('/user');
        

     }

     /*
      *    show car detail page.
      */
     public function showCarDetail ($id) {
        
        $userprofile = Userofcar::where('userofcar_id', $id)->leftjoin('cars', 'userofcars.car_id', 'cars.id')->first();
        $notifications = Notification::where('userofcar_id', $id)
                                     ->join('notification_types', 'notifications.notification_type_id', 'notification_types.notification_type_id')
                                     ->get();
        $data = array(
          'userprofile' => $userprofile,
          'notifications' => $notifications
        ); 
        return View('pages.userpage.usercar')->with($data);
       // echo json_encode($notifications);

     }

     /*
      *   delete car from userprofile
      */

     public function deleteCar ($id) {
        Userofcar::where('userofcar_id', $id)->delete();
        return redirect('/mycar');
     }

     /*
      *   update user profile
      */

     public function updateUserProfile (Request $request) {
        $userofcar_id = $request->userofcar_id;
        $status = $request->status;
        $current_mileage = $request->current_mileage;
        $annual_miles = $request->annual_miles;
        $notification_type = $request->notification_type;
        $notification_status = $request->notification_status;
        $description_name = $request->description_name;
        // all notification remove from user profile related given userofcar id
        if(count($notification_type) >= 1) {
          Notification::where('userofcar_id', $userofcar_id)->delete();
          Userofcar::where('userofcar_id', $userofcar_id)->update([
              'current_mileage' => $current_mileage,
              'annual_miles'    => $annual_miles,
              'notification_status' => $status,
              'description_name' => $description_name,
              'notification_status' => 1
          ]);
          for($i=0; $i<count($notification_status); $i++){
                 $type_id = NotificationType::where('notification_type_name', $notification_type[$i])->first()->notification_type_id;
                 $notification_data = [
                   'notification_type_id' => $type_id,
                   'userofcar_id'         => $userofcar_id,
                   'status'               => $notification_status[$i]
                 ];
                 Notification::insert($notification_data);
          }         
        }
        else{
          Notification::where('userofcar_id', $userofcar_id)->delete();
          Userofcar::where('userofcar_id', $userofcar_id)->update([
              'current_mileage' => $current_mileage,
              'annual_miles'    => $annual_miles,
              'notification_status' => $status,
              'description_name' => $description_name,
              'notification_status' => 0
          ]);
        }
        

        // return redirect('/mycar');

       echo json_encode($request->all());
       exit;
     }
     /*
      *   service detail page navigation
      */
     public function serviceDetail($id, $event_id) {

       $serviceofshop_id = $id;
       
       $services = Serviceofshop::where('serviceofshop_id', $id)                            
                                ->join('serviceofcars', 'serviceofshops.serviceofcar_id', 'serviceofcars.id')
                                ->join('cars', 'serviceofcars.car_id', 'cars.id')
                                ->join('services', 'serviceofcars.service_id', 'services.id')
                                ->join('categorys', 'services.category_id', 'categorys.id')->first();
      $master = Masterserviceofshop::where('serviceofshop_id', $id)
                                    ->join('masters', 'masterserviceofshops.master_id', 'masters.master_id')->first();
      $prices = Price::where('serviceofshop_id', $id)
                     ->join('pricetypes', 'prices.pricetype_id', 'pricetypes.pricetype_id')->get();
      $price_type = Price::where('serviceofshop_id', $id)
                         ->join('querys', 'prices.query_id', 'querys.query_id')->first();

       $data = array(

         'service' => $services,
         'prices'   => $prices,
         'price_type' => $price_type,
         'master'  => $master,
         'number' => count($prices),
         'event_id' => $event_id
       );
     
   //  return json_encode($data);

     return View('pages.userpage.servicedetail')->with($data);
     }

     /*
      *   service rate assist
      */
     public function rateService (Request $request) {

      $serviceofshop_id = $request->id;
      $mark = $request->rate;       
      $service_date = date("Y-m-d h:i A", strtotime($request->service_date));
      $rating_date = date("Y-m-d", strtotime("now"));

      $rate = Rate::where('serviceofshop_id', $serviceofshop_id)
                  ->where('user_id', Auth::user()->id)
                  ->where('service_date', $service_date)->first();

      if(isset($rate)) {
          //update
          Rate::where('serviceofshop_id', $serviceofshop_id)
                  ->where('user_id', Auth::user()->id)
                  ->where('service_date', $service_date)->update([
              'value' => $mark,
              'rating_date' => $rating_date
          ]);
      }
      else{

        $data = array(
            'serviceofshop_id' => $serviceofshop_id,
            'value' => $mark,
            'service_date' => $service_date,
            'rating_date' => $rating_date
        );
        Rate::insert($data);      
      }      

      $user_id = Auth::user()->id;
      $user = User::where('id', $user_id)->first();
      $shop = Serviceofshop::where('serviceofshop_id', $serviceofshop_id)
                           ->join('shopofinfos', 'serviceofshops.shopofinfos_id', 'shopofinfos.id')
                           ->leftjoin('serviceofcars', 'serviceofshops.serviceofcar_id', 'serviceofcars.id')
                           ->leftjoin('cars', 'serviceofcars.car_id', 'cars.id')
                           ->leftjoin('services', 'serviceofcars.service_id', 'services.id')
                           ->leftjoin('categorys', 'services.category_id', 'categorys.id')->first();
      $user->notify(new UserRateNotification($shop));
      $shopinfo = Serviceofshop::where('serviceofshop_id', $serviceofshop_id)
                                ->join('shopofusers', 'serviceofshops.shopofinfos_id', 'shopofusers.shopofinfo_id')->first();
      $shopowner_id = $shopinfo->user_id;
      $shopowner = User::where('id', $shopowner_id)->first();
      $shopowner->notify(new ShopownerRateNotification($shop, $user, $mark)); 
        
     }
    /**
     *  shopowner register
     *
     *  @param shopinfo
     */
    public function registerShop (Request $request) {

        $this->validate($request, array(
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'address' => 'required|regex:/^\d+ [a-zA-Z ]+/',
            'city'  => 'required|regex:/^([a-zA-Z ]+)$/',
            'state' => 'required|regex:/[A-Z]{2}/',
            'password' => 'required|string|min:6',
            'shopname' => 'required|string|max:255',
            'zipcode' => 'required|regex:/^\d{5}$/',
            'barnumber' => 'required|numeric|min:6|max:999999999',
            'epanumber' => 'required|numeric|min:6|max:999999999',
            'phonenumber' => 'required',
        ));

        $user = new User;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $user_id = $user->id;       
       


        $roleuser = new RoleUser;
        $roleuser->user_id = $user_id;
        $roleuser->role_id = 3;
        $roleuser->save();
        
        $shopofinfo = new Shopofinfo;
        $shopofinfo->shop_name = $request->shopname;
        $shopofinfo->address = $request->address;
        $shopofinfo->city = $request->city;
        $shopofinfo->state = $request->state;
        $shopofinfo->zip_code = $request->zipcode;
        $shopofinfo->shop_phonenumber = $request->phonenumber;
        $shopofinfo->BAR_number = $request->barnumber;
        $shopofinfo->EPA_number = $request->epanumber;      
        $shopofinfo->save();

        $shopofinfo_id = $shopofinfo->id;

        // Subscriptionplan::insert($shopofinfo_id, $subscription_plan, 0);

        $shopofuser = new Shopofuser;
        $shopofuser->user_id = $user_id;
        $shopofuser->shopofinfo_id = $shopofinfo_id;
        $shopofuser->save();
        
        session()->put('shopownercreate', $user_id);
        return redirect('/shop_owner');
    }

    /**
     *  Shop operator page navigation
     */
    public function shopOperator () {
      $shopofinfos = Shopofinfo::all();
      $send_data = array();
      foreach ($shopofinfos as $shop) {
        $plan = Subscriptionplan::where('shopofinfo_id', $shop['id'])->first();
        $valid = Shophour::checkValid($shop['id']);


        $user_id = Shopofuser::where('shopofinfo_id', $shop['id'])->first()->user_id;
        $file = File::where('user_id', $user_id)->get();
        foreach ($file as $item) {
            if($item['file_type'] == 0) $insurance = $item['status'];
            if($item['file_type'] == 1) $license = $item['status'];
        }
        $data = array(
            'shopid' => $shop['id'],
            'shopname' => $shop['shop_name'],
            'BAR_status' => $shop['barnumber_valid'],
            'EPA_status' => $shop['epanumber_valid'],
            'plan'   => isset($plan) ? $plan['subscription_plan']:null,
            'status' => isset($plan) ? $plan['status']:null,
            'valid' => $valid,
            'insurance' => isset($insurance)? $insurance:null,
            'license' =>   isset($license)? $license:null,
        );
        array_push($send_data, $data);
      }
      
      $array = array('shop_data' => $send_data);
      return View('pages.admin.operator')->with($array);
      // echo json_encode($array);
      // exit;
    }

    public function operatorUpdate(Request $request) {
        $shopid = $request->id;
        $license = $request->license;
        $insurance = $request->insurance;
        $status = $request->status;
        $barstatus = $request->barstatus;
        $epastatus = $request->epastatus;
        switch ($license) {
            case 'notupload':
                $license_status = null;
                break;
            
            case 'valid':
                $license_status = 1;
                break;
            case 'processing':
                $license_status = 0;
                break;
            case 'recertification':
                $license_status = 2;
                break;          
        }

         switch ($insurance) {
            case 'notupload':
                $insurance_status = null;
                break;
            
            case 'valid':
                $insurance_status = 1;
                break;
            case 'processing':
                $insurance_status = 0;
                break;
            case 'recertification':
                $insurance_status = 2;
                break;          
        } 
       
        switch ($status) {
            case 'active':
                $plan_status = 0;
                break;            
            case 'expire':
                $plan_status = 1;
                break;
            case 'notactive':
                $plan_status = 2;
                break;
        
        }      
        
        switch ($barstatus) {
            case 'valid':
                $bar = 1;
                break;            
            case 'notvalid':
                $bar = 0;
                break;
        }
        switch ($epastatus) {
            case 'valid':
                $epa = 1;
                break;            
            case 'notvalid':
                $epa = 0;
                break;
        }
        $user_id = Shopofuser::where('shopofinfo_id', $shopid)->first()->user_id;     
        if(isset($insurance_status)) File::where('user_id', $user_id)->where('file_type', 0)->update(['status' => $insurance_status]);
        if(isset($license_status)) File::where('user_id', $user_id)->where('file_type', 1)->update(['status' => $license_status]);
        if(isset($plan_status)) Subscriptionplan::where('shopofinfo_id', $shopid)->update(['status' => $plan_status]); 
        if(isset($epa) && isset($bar)) Shopofinfo::where('id', $shopid)->update(['barnumber_valid' => $bar, 'epanumber_valid' => $epa]);      
    }
   
}
