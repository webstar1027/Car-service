<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Userofcar extends Model
{
    //
    protected $table = 'userofcars';	
	public $timestamps = true;	
	protected $fillable = [
	   'user_id', 'car_id', 'current_mileage', 'annual_miles', 'notificationofservice_id', 'notification_status'
	];

	/*
	 *   find id selected car
	 */
	public static function findById($id1, $id2){
		$usercar = Userofcar::where('user_id', $id1)
		  					->where('car_id', $id2)->first();
		if($usercar){
			return true;
		}
		else{
			return false;
		}

	}

	/*
	 *  add new row data
	 */
	public static function insert($data) {
		$userofcar = new Userofcar;
		$userofcar->user_id = $data['user_id'];
		$userofcar->car_id = $data['car_id'];
		$userofcar->current_mileage = $data['current_mileage'];
		$userofcar->annual_miles = $data['annual_miles'];
		$userofcar->description_name = $data['description_name'];
		$userofcar->notification_status = $data['notification_status'];
		$userofcar->save();
		return $userofcar->id;
	}
}
