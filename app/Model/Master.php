<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Masterserviceofshop;

class Master extends Model
{
    //
    protected $table = "masters";
    protected $fillable = [
    	'master_service_name'
    ];
	 /*
	 -----------------------------------------------------------------------------------
	 |  Set 1:n relationship between master service model and masterserviceofshop model |
	 |----------------------------------------------------------------------------------
	 */
	public function masterserviceofshop() {
		return $this->belongsToMany('App\Model\Masterserviceofshop');
	}

	/*
     -----------------------------------------------------------------------------------
     |  save master service name to master table.                                       |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       master service name : string                                               |
     | @return                                                                          |
     |       void                                                                       |
     -----------------------------------------------------------------------------------
     */
     public static function insert($name) {

     	if($name){
     		$master = new Master;
     		$master->master_service_name = $name;
     		$master->save();
     		
     	}

     }
    
}
