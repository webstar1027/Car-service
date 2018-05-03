<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    //
    protected $table = "notifications";
    protected $fillable = [
    	'notification_type_id', 'userofcar_id', 'status'
    ];

    public static function insert ($data) {
    	$notification = new Notification;
    	$notification->notification_type_id = $data['notification_type_id'];
    	$notification->userofcar_id = $data['userofcar_id'];
    	$notification->status = $data['status'];
    	$notification->save();
    }
}
