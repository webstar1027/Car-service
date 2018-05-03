<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Pricetype extends Model
{
    //
    protected $table = "pricetypes";
    protected $fillable =[

    	'pricetype_name'

    ];

    /*
	 -----------------------------------------------------------------------------------
	 |  Set 1:n relationship between price model and pricetype model                    |
	 |----------------------------------------------------------------------------------
	 */
	public function prices() {
		return $this->belongsToMany('App\Model\Price');
	}

	public static function findById($itemname) {

		if(isset($itemname)) {
			$itemtype = DB:: table('pricetypes')->where('pricetype_name', $itemname)->first();
			if(isset($itemtype)){
				return $itemtype->pricetype_id;
			}
			else{
				return 'there is no such item type';
			}
		}
	}
}
