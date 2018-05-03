<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class Rate extends Model
{
    //
    protected $table = "rates";
    protected $fillable = [
      'user_id', 'serviceofshop_id', 'value', 'rating_date', 'service_date'
    ];
    public static function insert($data) {
    	$rate = new Rate;
    	$rate->user_id = Auth::user()->id;
    	$rate->serviceofshop_id = $data['serviceofshop_id'];
    	$rate->value = $data['value'];
    	$rate->rating_date = $data['rating_date'];
    	$rate->service_date = $data['service_date'];
    	$rate->save();
    }
}
