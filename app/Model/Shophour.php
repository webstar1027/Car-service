<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Shophour extends Model
{
    //
  protected $table ='shophours';
  protected $fillable = [
  	'shopofinfo_id', 'open_date', 'close_date', 'dayofweek', 'open_time', 'close_time'
  ];

  public static function checkValid ($id) {
  	
  	$shophour = Shophour::where('shopofinfo_id', $id)->get();   
  
    if(count($shophour) > 0) {
      foreach ($shophour as $hour) {
        if( $hour['close_time'] == '' ){         
          return 'false';
        }    
      }
      return 'true';
    }
    else{
      return 'no regist';   
    }

  }


}
