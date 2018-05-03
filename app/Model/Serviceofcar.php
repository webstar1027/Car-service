<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Model\Serviceofcar;
use App\Model\Category;
use App\Model\Service;
class Serviceofcar extends Model
{
    //
    protected $table = 'serviceofcars';	
		public $timestamps = true;	
		protected $fillable = [
		  'service_id',	 
		  'car_id'
		];

	/*
	 -----------------------------------------------------------------------------------
	 |  Set 1:n relationship between serviceofcar model and car model                   |
	 |----------------------------------------------------------------------------------
	 */
		public function car() {
			return $this->hasMany('App\Model\Car');
		}
	/*
	 -----------------------------------------------------------------------------------
	 |  Set 1:n relationship between serviceofcar model and service model               |
	 |----------------------------------------------------------------------------------
	 */
		public function service() {
			return $this->hasMany('App\Model\Service');
		}

	/*
	 -----------------------------------------------------------------------------------
	 |  Set 1:n relationship between serviceofcar model and serviceofshop model         |
	 |----------------------------------------------------------------------------------
	 */
		public function serviceofshop() {
			return $this->belongsToMany('App\Model\Serviceofshop');
		}
	 /*
     -----------------------------------------------------------------------------------
     | Get serviceofcar_id from serviceofcars table by given service_id and car_id.     |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       car_id : int , service_id : int                                            |
     | @return                                                                          |
     |       serviceofcar_id : int                                                      |
     -----------------------------------------------------------------------------------
     */
		public static function findById($car_id, $service_id) {
			if(isset($car_id) && isset($service_id)) {
				$serviceofcar = DB::table('serviceofcars')->where('car_id', $car_id)
												 ->where('service_id', $service_id)->first();	
												 
				if (!isset($serviceofcar)) {

					DB::table('serviceofcars')->insert([
						'car_id' => $car_id,
						'service_id' => $service_id
					]);

					$serviceofcar_id = DB::table('serviceofcars')->max('id');

					return $serviceofcar_id;
					
				}
				else {

					return $serviceofcar->id;
				}
			}
		}
	 /*
     -----------------------------------------------------------------------------------
     | Get serviceofcar_id from serviceofcars table by given service_id and car_id.     |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       car_id : int , service_id : int                                            |
     | @return                                                                          |
     |       serviceofcar_id : int                                                      |
     -----------------------------------------------------------------------------------
     */
		public static function findByCarId($id) {
			if(isset($id)) {
				$serviceofcar = DB::table('serviceofcars')->where('car_id', $id)->get();												 
												 
				if (count($serviceofcar) == 0) {
					echo "There is no such service of that car";
					exit;
				}
				else {
					$service_data = array();
					foreach ($serviceofcar as $item) {
						$service = Serviceofcar::where('serviceofcars.service_id', '=', $item->service_id)
																	 ->join('services', 'serviceofcars.service_id', '=', 'services.id')
																	 ->join('categorys', 'services.category_id', '=', 'categorys.id')->first();
						if(!isset($service)) continue;
						array_push($service_data, $service->category_name);
					}
					return $service_data;
				}
			}
		}

	/*
     -----------------------------------------------------------------------------------
     | check if servcie exists or not from serviceofcars table by given service_id      |
     | and car_id.                                                                      |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       car_id : int , service_id : int                                            |
     | @return                                                                          |
     |       boolean (if exist return true, if not return false)                        |
     -----------------------------------------------------------------------------------
     */
     public static function serviceCheck($car_id, $service_id) {

     	$service = Serviceofcar::where('car_id', $car_id)
     							->where('service_id', $service_id)->first();
     	if (isset($service)) {

     		return $service->id;
     	}
     	else{
     		return false;
     	}


     }

}
