<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    //
    //
    protected $table = "querys";
    protected $fillable =[
    	'query_name'
    ];

    /*
	 -----------------------------------------------------------------------------------
	 |  Set 1:n relationship between price model and query model                    |
	 |----------------------------------------------------------------------------------
	 */
	public function price() {
		return $this->belongsToMany('App\Model\Price');
	}
}
