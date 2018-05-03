<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Model\Car;
use App\Model\Serviceofcar;
use App\Model\Category;
use App\Model\Service;
use App\Model\Serviceofshop;
use App\Model\Shopofinfo;
use App\Model\Shopofuser;
use App\Model\Price;
use App\Model\Pricetype;
use App\Model\Query;
use App\Model\Master;
use App\Model\Masterserviceofshop;
use App\Model\Event;
use App\Model\Shophour;
use App\Model\ShopBlockSchedule;
use App\Model\Calendar;
use App\Services\GoogleService;
use App\Services\ShopSchedule;
class Event extends Model
{
    //
     protected $table ='events';
     protected $fillable = ['event_name','shop_id','start_time', 'user_id', 'duration'];
     public static function serviceAppoint ($id, $date) {

      $service = Serviceofshop::where('serviceofshop_id', $id)
                              ->join('shopofinfos', 'serviceofshops.shopofinfos_id', 'shopofinfos.id')
                              ->join('serviceofcars', 'serviceofshops.serviceofcar_id', 'serviceofcars.id')                             
                              ->join('services', 'serviceofcars.service_id', 'services.id')
                              ->join('categorys', 'services.category_id', 'categorys.id')->first();

    
        $event = new Event;
        $event->event_name = $service['category_name'];
        $event->shop_id = $service['shopofinfos_id'];
        $event->car_id = $service['car_id'];
        $event->start_time = $date;
        $event->duration = $service['complete_time'];
        $event->user_id = Auth::user()->id;
        $event->save();

    }
}
