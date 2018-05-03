<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Service extends Model
{
    //
    protected $table = 'services';	
	public $timestamps = true;	
	protected $fillable = [
	   'category_id', 'questions'
	];

	/*
	 -----------------------------------------------------------------------------------
	 |  Set 1:1 relationship between service model and category model                   |
	 |----------------------------------------------------------------------------------
	 */
	public function category() {
		return $this->hasOne('App\Model\Category');
	}

	/*
	 -----------------------------------------------------------------------------------
	 |  Set 1:n relationship between serviceofcar model and service model               |
	 |----------------------------------------------------------------------------------
	 */
	public function serviceofcar() {
		return $this->belongsToMany('App\Model\Serviceofcar');
	}

	 /*
     -----------------------------------------------------------------------------------
     | Get service_id from services table by given category_id.                         |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       category_id : int 		                                                    |
     | @return                                                                          |
     |       service_id : int                                                           |
     -----------------------------------------------------------------------------------
     */
	public static function findById($id) {
		if(isset($id)) {
			$service = DB::table('services')->where('category_id', $id)->first();			
			if(!isset($service)){
				echo "There is no defined service responding to that category";
				exit;
			}
			else{
				return  $service->id;
			}							 
		}
	}
}
