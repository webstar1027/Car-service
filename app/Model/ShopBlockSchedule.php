<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Services\ShopSchedule;
use DateTime;
use DateInterval;
use DatePeriod;
class ShopBlockSchedule extends Model
{
    //
    protected $table = 'shopblockschedules';
    protected $shopschedule;
    protected $fillable = [
    	'shopofinfo_id', 'block_type', 'block_date', 'open_time', 'close_time'
    ];
  
    public static function insert($data){
    	$shopblockschedule = new ShopBlockSchedule;
    	$shopblockschedule->description = $data['block_description'];
    	$shopblockschedule->shopofinfo_id = $data['id'];
    	$shopblockschedule->block_type = 0;
    	$shopblockschedule->block_date = $data['alwaysdate'];
    	$shopblockschedule->open_time = $data['always_start_time'];
    	$shopblockschedule->close_time = $data['always_end_time'];
    	$shopblockschedule->save();

    }
   /*
    *  shop one time schedule insert
    */
    public static function onetimeInsert($data){
    	$shopblockschedule = new ShopBlockSchedule;
    	$shopblockschedule->shopofinfo_id = $data['id'];
    	$shopblockschedule->description = $data['block_description'];
    	$shopblockschedule->block_type = 1;
    	$shopblockschedule->block_date = $data['onetimedate'];
    	$shopblockschedule->open_time = $data['onetime_start_time'];
    	$shopblockschedule->close_time = $data['onetime_end_time'];
    	$shopblockschedule->save();

    }
   /*
	* shop block schedule update
	*/
	public static function blockupdate ($data) {
		
		ShopBlockSchedule::where('shopblockschedule_id', $data['id'])->update([
			'description' => $data['description'],
			'block_date'  => $data['date'],
			'open_time'   => $data['start_time'],
			'close_time'  => $data['end_time']
		]);


	}

  /**
   *  shop block date and time check
   *
   *  @var weekarray, shop id
   */

  public static function compareTime($date, $time, $id){
    $shopblockschedule = ShopBlockSchedule::where('shopofinfo_id', $id)->get();      
    $available_time = array();
    foreach ($shopblockschedule as $schedule) {

        if($schedule['block_type'] == 0) {
          $weekdays = ShopBlockSchedule::getweekDays($schedule['block_date'], 'Y-m-d');
        }
        if( ($schedule['block_type'] == 1 && $schedule['block_date'] == $date) || ($schedule['block_type'] == 0 && in_array($date, $weekdays)) ) {
           $block_time = $schedule['open_time']."-".$schedule['close_time'];

           $time_data = explode('-', $time);
           $block_time = explode('-', $block_time);
           
           $opentime = strtotime($time_data[0]);
           $blocktime = strtotime($block_time[0]);
           
           if($opentime >= $blocktime){
            $available_time[0] = null;
           }
           else{
            $available_time[0] = $time_data[0]."-".$block_time[0];
           }

           $ot = strtotime($time_data[1]);
           $bt = strtotime($block_time[1]);
           
           if($ot <= $bt){
            $available_time[1] = null;
           }
           else{
            $available_time[1] = $block_time[1]."-".$time_data[1];
           }
         
        }    
       
    }

    if(count($available_time) > 0){
      return $available_time;
    }
    else{
      return "no block";
    }
  }

  public static function getweekDays($blockdate, $format){

    $days = array();
    $year = date("Y", strtotime("now"));
    $startDate = new DateTime("{$year}-01-01 {$blockdate}");
    $year++;
    $endDate = new DateTime("{$year}-01-01");
    $int = new DateInterval('P7D');
    foreach(new DatePeriod($startDate, $int, $endDate) as $d) {
        $days[] = $d->format($format);
    }
    return $days;
  }

}
