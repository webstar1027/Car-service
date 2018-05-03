<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Model\Query;
class Price extends Model
{
    //
    protected $table = "prices";
    protected $fillable = [
    	'pricetype_id', 'price', 'descrption'
    ];
    /*
	 -----------------------------------------------------------------------------------
	 |  Set 1:n relationship between price model and pricetype model                    |
	 |----------------------------------------------------------------------------------
	 */
	public function pricetypes() {
		return $this->hasMany('App\Model\Pricetype');
	}
    
    /*
	 -----------------------------------------------------------------------------------
	 |  Set 1:n relationship between price model and query model                    |
	 |----------------------------------------------------------------------------------
	 */
	public function querys() {
		return $this->hasMany('App\Model\Query');
	}
	public static function insert ($data) {
		if (isset($data)) {
	
            $query_id = Query::where('query_name', $data['query_index'])->first()->query_id;
			$price = new Price;
			$price->serviceofshop_id = $data['serviceofshop_id'];
			$price->pricetype_id  = $data['itemtype_id'];
			$price->description = $data['item_description'];
			$price->price = $data['item_price'];
			$price->query_id = $query_id;
			$price->save();
			echo json_encode($data);
		}
	}

}
