<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Master;
use App\Model\Serviceofshop;
class Masterserviceofshop extends Model
{
    //
    protected $table = "masterserviceofshops";
    protected $fillable = [
    	'master_id', 'serviceofshop_id'
    ];
     /*
	 -----------------------------------------------------------------------------------
	 |  Set 1:n relationship between master service model and masterserviceofshop model |
	 |----------------------------------------------------------------------------------
	 */
	public function masters() {
		return $this->hasMany('App\Model\Master');
	}
	 /*
	 -----------------------------------------------------------------------------------
	 |  Set 1:n relationship between serviceofshop model and masterserviceofshop model |
	 |----------------------------------------------------------------------------------
	 */
	public function serviceofshops() {
		return $this->hasMany('App\Model\Serviceofshop');
	}

    public static function insert($id1, $id2){
    	$masterserviceofshop = new Masterserviceofshop;
    	$masterserviceofshop->master_id = $id1;
    	$masterserviceofshop->serviceofshop_id = $id2;    	
    	$masterserviceofshop->save();
    }
}
