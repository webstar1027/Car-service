<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Model\Shopofinfo;
use App\Model\Masterserviceofshop;
use App\Model\Calendar;
use App\Model\Event;
class Serviceofshop extends Model
{
    //
    protected $table = 'serviceofshops';	
	public $timestamps = true;	
	protected $fillable = [
	   'shopofinfos_id',
	   'serviceofcar_id'
	];
	/*
	 -----------------------------------------------------------------------------------
	 |  Set 1:n relationship between shopofinfo model and serviceofshop model           |
	 |----------------------------------------------------------------------------------
	 */
	public function shopofinfo() {
		return $this->hasMany('App\Model\Shopofinfo');
	}
	/*
	 -----------------------------------------------------------------------------------
	 |  Set 1:n relationship between serviceofcar model and serviceofshop model         |
	 |----------------------------------------------------------------------------------
	 */
	public function serviceofcar() {
		return $this->hasMany('App\Model\Serviceofcar');
	}
    /*
      -----------------------------------------------------------------------------------
      |  Set 1:n relationship between serviceofshop model and masterserviceofshop model |
      |----------------------------------------------------------------------------------
      */
     public function masterserviceofshop() {
          return $this->belongsToMany('App\Model\Masterserviceofshop');
     }
	 /*
     -----------------------------------------------------------------------------------
     | Get shop data from serviceofshops and shopinfos table by given serviceofcar id.  |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       sericeofcar_id : int                                                       |
     | @return                                                                          |
     |      array(shop_name:string, zip_code:string, price:string)                      |
     -----------------------------------------------------------------------------------
     */
	public static function findByServiceId($id) {
		if(isset($id)) {
			$shopservices = DB::table('serviceofshops')->where('serviceofcar_id', $id)->get();

			if (count($shopservices) == 0) {
				return null;
			}	
			else {
				$send_data = array();
				foreach($shopservices as $item) {
					$shop_id = $item->shopofinfos_id;
					$shop_data = Shopofinfo::getNameById($shop_id);
					
					$price = $item->price;
					$data = array(
						'shop_name' => $shop_data['shop_name'],
						'zip_code'  => $shop_data['zip_code'],
						'price'     => $price
					);

					array_push($send_data, $data);
				}
			
				return $send_data;			
			}			 
		}
	}

	/*
     -----------------------------------------------------------------------------------
     | Get service data from serviceofshops table by given shop id.						|
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       shop_id : int                                                      		|
     | @return                                                                          |
     |      array( year:string, make:string, model:string, term:string, price:string,   |
     |            category_name:string)                                                 |
     -----------------------------------------------------------------------------------
     */
     public static function getService($id) {

     	$shops = Serviceofshop::where('serviceofshops.shopofinfos_id', '=', $id)
     							->join('serviceofcars', 'serviceofshops.serviceofcar_id', 'serviceofcars.id')
     							->join('cars', 'serviceofcars.car_id', 'cars.id')
     							->join('services', 'serviceofcars.service_id', 'services.id')
     							->join('categorys', 'services.category_id', 'categorys.id')->get();
     	if(count($shops) == 0) {
     		return "That shop is not registered";
     	}else{
	     	$shopservice = array();
	     	foreach($shops as $shop) {

	     		$data = array(

	     			'year' => $shop->year,
	     			'make' => $shop->make,
	     			'model'=> $shop->model,
	     			'term' => $shop->term,
	     			'cylinder' => $shop->cylinder,
	     			'level' => $shop->level,
	     			'category_name' => $shop->category_name,
	     			'price' => $shop->price
	     		);

	     		array_push($shopservice, $data);

	     	}

	     	return $shopservice;
	     }
     }

     /*
     -----------------------------------------------------------------------------------
     |  update shop service from serviceofshop table.             						|
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       id:int, serviceofcar_id:int, shopofinfos_id:int, price:varchar       		|
     | @return                                                                          |
     |       bool (if success return true, if fail return false)                        |
     -----------------------------------------------------------------------------------
     */
     public static function updateService($id, $service_id, $shop_id, $price, $descriptions){

     	if (Serviceofshop::check($service_id, $shop_id, $price) != true ){

     		$id = Serviceofshop::check($service_id, $shop_id, $price);
     	}  		
 		DB::table('serviceofshops')->where('serviceofshop_id', $id)->update([
 			'serviceofcar_id' => $service_id,
 			'shopofinfos_id' => $shop_id,
 			'price'		  => $price,
               'descriptions'   => $descriptions
 		]);
          
 		echo "Update is successed !";
 		exit;
     	
     }
    /*
     -----------------------------------------------------------------------------------
     |  delete shop service from serviceofshop table.             						|
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       id:int                                                             		|
     | @return                                                                          |
     |       bool (if success return true, if fail return false)                        |
     -----------------------------------------------------------------------------------
     */
     public static function deleteService($id){     	
 		DB::table('serviceofshops')->where('id', $id)->delete();
 		$shopservice = DB::table('serviceofshops')->where('serviceofshop_id', $id)->first();
 		if (isset($shopservice)) {
 			echo "failed!";
 			exit;
 		}
 		else{
 			echo "delete is successed !";
 			exit;
 		}
 		
     	
     }

    /*
     -----------------------------------------------------------------------------------
     |  check if update content exits in serviceofshop table.      				        |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       id:int, serviceofcar_id:int, shopofinfos_id:int, price:varchar       	    |
     | @return                                                                          |
     |       bool (if exits return true, if empty return false)                         |
     -----------------------------------------------------------------------------------
     */
     public static function check($service_id, $shop_id, $price) {

     	$shopservice = DB::table('serviceofshops')->where('serviceofcar_id', $service_id)
     							   ->where('shopofinfos_id', $shop_id)->first();

     	if (isset($shopservice)) {

     		return $shopservice->serviceofshop_id;
     	}
     	else{

     		return true;
     	}

     }


     /**
      *  shop service complete time available time get
      *
      *  @var complete time, weekday available time
      */

     public static function getAvailableTime($complete_time, $time) {
        $available_time = array();
        if( is_array($time)) {
          foreach($time as $item){
            if($item != null) {
              $time_data = explode('-', $item);
              $duration = (strtotime($time_data[1])-strtotime($time_data[0]))/60;
              if($duration >= intval($complete_time)){
                $number = $duration/intval($complete_time);
                $start_time = strtotime($time_data[0]);
                for($i = strtotime($time_data[0]); $i < strtotime($time_data[1]); $i= $i+intval($complete_time)*60){
                  array_push($available_time, date("h:i A", $i));
                }
              }
            }           
          }
        }
        else{

          $time_data = explode('-', $time);
          $duration = (strtotime($time_data[1])-strtotime($time_data[0]))/60;
          if($duration >= intval($complete_time)){
            $number = $duration/intval($complete_time);
            $start_time = strtotime($time_data[0]);
            for($i = strtotime($time_data[0]); $i < strtotime($time_data[1]); $i= $i+intval($complete_time)*60){
              array_push($available_time, date("h:i A", $i));
            }
          }

        }

        return $available_time;
     }

     /**
      *  shop service book time get
      *
      *  @var  weekday available time, service id
      */

     public static function getBookTime($date, $time, $complete_time, $service_id) {
       
       $shopbooks = Event::where('shop_id', $service_id)->get();
       foreach($shopbooks as $item) {
           
           $bookdate = date("Y-m-d", strtotime($item['start_time']));
           $bookstarttime = date("H:i A", strtotime($item['start_time']));
           $bookendtime = date('H:i A', strtotime('+'.$item['duration'].' minutes',strtotime($bookstarttime)));

           $appointdate = date("Y-m-d", strtotime($date));

          /*
           *   appoint time duration calc.
           */
           if($bookdate == $appointdate) {
               //
                if(isset($time) && count($time) > 0) {

                 foreach($time as $onetime) {

                    $appointstarttime = date("H:i A", strtotime($onetime));
                    $appointendtime = date("H:i A", strtotime('+'.$complete_time.' minutes', strtotime($appointstarttime)));

                    // start same
                    if (($bookstarttime == $appointstarttime) && ( ($bookendtime < $appointendtime) || ($bookendtime == $appointendtime) ) ) {

                       $key = array_search($onetime, $time);
                       array_splice($time, $key, 1);
                    }
                    elseif (($bookstarttime == $appointstarttime) && ($bookendtime > $appointendtime)) {

                       $key = array_search($onetime, $time);
                       array_splice($time, $key, 1);

                       if(in_array($appointendtime, $time)){

                         $key1 = array_search($appointendtime, $time);
                         array_splice($time, $key, 1);
                       }
                    }

                    // // start time are different.

                    // if($appointendtime > $bookstarttime && $appointstarttime < $bookstarttime) {

                    //   $key = array_search($appointstarttime, $time);
                    //   array_splice($time, $key, 1);

                    // }
                    // if($bookendtime >= $appointendtime && $appointstarttime > $bookstarttime) {

                    //   $key = array_search($appointstarttime, $time);
                    //   array_splice($time, $key, 1);

                    // }
                    //  if($bookendtime <= $appointendtime && $appointstarttime > $bookstarttime) {

                    //   $key = array_search($appointstarttime, $time);
                    //   array_splice($time, $key, 1);

                    // }

                 }

               }       
                   //
           }
       }

       return $time;

     }

     


}
