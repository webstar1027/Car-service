<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Handler;
class Car extends Model
{
    //
    protected $table = 'cars';	
  	public $timestamps = true;	
  	protected $fillable = [
  	  'year',
  	  'make',
  	  'model',
  	  'term',
  	  'cylinder',
  	  'status'
  	];

  	/*
  	 -----------------------------------------------------------------------------------
  	 |  Set 1:n relationship between serviceofcar model and car model                   |
  	 |----------------------------------------------------------------------------------
  	 */
    	public function serviceofcar() {
    		return $this->belongsToMany('App\Model\Serviceofcar');
    	}
     /*
     -----------------------------------------------------------------------------------
     | Get  car id from car table about given car information.                          |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       year:string,  make:string,  term:string,  model:string                     |
     | @return                                                                          |
     |      car_id:int 								                                                  |
     -----------------------------------------------------------------------------------
     */
    	public static function findById($data) {
    		if(isset($data)) {				
    			$car = DB::table('cars')->where('year', $data['year'])
    							 		  ->where('make', $data['make'])
    							 		  ->where('term', $data['term'])
                        ->where('model', $data['model'])->first();	
    			if(!isset($car)) {    			  
             return false;
    			}
    			else {
    				return $car->id;
    			}
    		
    		}
    	}
    /*
     -----------------------------------------------------------------------------------
     | Find car make by given car year.                                                 |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       year:string                                                                |
     | @return                                                                          |
     |      make:string                                                                 |
     -----------------------------------------------------------------------------------
     */
      public static function findMakeByYear($year) {
        if(isset($year)) {        
          $car = DB::table('cars')->where('year', $year)->get();                        
          $make = array();
          foreach ($car as $item) {
            if(in_array($item->make, $make)) continue; else array_push($make, $item->make);

          }

          return $make;
        
        }
      }

  	  /*
       -----------------------------------------------------------------------------------
       | Add new car informations to car table.                                           |
       |----------------------------------------------------------------------------------
       | @param                                                                           |
       |       year: string,  make:string,  term:string,  model:string, cylinder:string   |
       | @return                                                                          |
       |       bool (if success return true, if fail return false)                        |
       -----------------------------------------------------------------------------------
       */

       public static function insert($data) {
       	if (isset($data)) {    

       		if(Car::check($data)){
       			return "false";
       		}
       		else{
       			
       			$old_id = DB::table('cars')->max('id');
       			DB::table('cars')->insert([
       				'year'      => $data['year'],
    					'make'      => $data['make'],
    					'model'     => $data['model'],
    					'term'      => $data['term'],
    					'cylinder'  => $data['cylinder'],
               'created_at'=> new \Datetime(),
               'updated_at'=> new \Datetime()
       			]);

       			$new_id = DB::table('cars')->max('id');

       			if ($old_id < $new_id) {

       				return "true";
       			}       			
       		}
       	}
       }
      /*
       -----------------------------------------------------------------------------------
       | Update  car informations to car table.                                           |
       |----------------------------------------------------------------------------------
       | @param                                                                           |
       |       year: string,  make:string,  term:string,  model:string, cylinder:string   |
       | @return                                                                          |
       |       bool (if success return true, if fail return false)                        |
       -----------------------------------------------------------------------------------
       */

       public static function updateCar($data, $id) {
       	if (isset($id)) {     			
       		$old_car = DB::table('cars')->where('id', $id)->first();
       		DB::table('cars')->where('id', $id)->update([
       			'year'      => $data['year'],
       			'make'      => $data['make'],
       			'model'     => $data['model'],
       			'term'      => $data['term'],
       			'cylinder'  => $data['cylinder'],                        
                      'updated_at'=> new \Datetime()
       		]);    
       		
       		$new_car = DB::table('cars')->where('id', $id)->first();     				
       		if ($old_car !== $new_car) {

       			echo "The update of data is successed !";
       		}
       		else {

       			echo "The update of data is failed !";
       		}
       	
       	}
       }
      /*
       -----------------------------------------------------------------------------------
       | delete given car informations to car table.                                       |
       |----------------------------------------------------------------------------------
       | @param                                                                           |
       |      id: int                                                                     |
       | @return                                                                          |
       |       bool (if success return true, if fail return false)                        |
       -----------------------------------------------------------------------------------
       */

       public static function deleteCar($id) {
       	if (isset($id)) {     			
       			
       			DB::table('cars')->where('id', $id)->delete();	
       			
       			$new_car = DB::table('cars')->where('id', $id)->first();    				
       			if (!isset($new_car)) {

       				echo "The remove of data is successed !";
       			}
       			else {

       				echo "The remove of data is failed !";
       			}
       		
       	}
       }



      /*
       -----------------------------------------------------------------------------------
       | check if new car informations exist on car table or not.                         |
       |----------------------------------------------------------------------------------
       | @param                                                                           |
       |       year: string,  make:string,  term:string,  model:string, cylinder:string   |
       | @return                                                                          |
       |       bool (if exist return true, if empty return false)                         |
       -----------------------------------------------------------------------------------
       */
       public static function check($data) {

         	$car = DB::table('cars')->where('year', $data['year'])
         							->where('make', $data['make'])
         							->where('model', $data['model'])
         							->where('term', $data['term'])->first();
         							
         	if (!isset($car)) {
         		return false;
         	}
         	else{
         		return true;
         	}

       }

       public static function findByCylinderId($cylinder) {

          if(isset($cylinder)) {

            $cars = Car::where('cylinder', $cylinder)->get();
            $car_id = array();
            foreach($cars as $car) {
              array_push($car_id, $car->id);
            }

            return $car_id;
          }

        
       }

}
