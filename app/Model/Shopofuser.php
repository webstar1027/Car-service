<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Model\Shopofinfo;
class Shopofuser extends Model
{
    //
    protected $table ='shopofusers';
    protected $fillable = [
    	'user_id', 'shopofinfo_id'
    ];
    /*
	 -----------------------------------------------------------------------------------
	 |  Set 1:n relationship between shopofinfo model and shopofuser model             |
	 |----------------------------------------------------------------------------------
	 */
	public function shopofinfo() {
		return $this->hasMany('App\Model\Shopofinfo');
	}
	 /*
	 -----------------------------------------------------------------------------------
	 |  Set 1:n relationship between shopofinfo model and user model             |
	 |----------------------------------------------------------------------------------
	 */
	public function user() {
		return $this->hasMany('App\User');
	}
	
}
