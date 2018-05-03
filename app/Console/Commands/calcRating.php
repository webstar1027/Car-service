<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Model\Rate;
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
class calcRating extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calcRatings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'calculates the rating for a shop based on it\'s scores';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        /*
         *  all shops rating calculation
         */
       $rates = Rate::all();
       $rate_data = array();

       $shop_data = array();
       foreach($rates as $rate) {
         $shop_id = Serviceofshop::where('serviceofshop_id', $rate['serviceofshop_id'])->first()->shopofinfos_id;
         if(!in_array($shop_id, $shop_data)) array_push($shop_data, $shop_id);
       }
       foreach($shop_data as $item) {
        $sum = 0;
        $count = 0;
         foreach ($rates as $rate) {
            $id = Serviceofshop::where('serviceofshop_id', $rate['serviceofshop_id'])->first()->shopofinfos_id;
            if ($id == $item) {
                $sum = $sum + $rate['value'];
                $count ++ ;
            }
         }         
        $rate_data[$item] = intval($sum/$count);
        Shopofinfo::where('id', $item)->update(['rating' => $rate_data[$item]]);

       }
       
      
      

    }
    public function rateAssist(){

    }
}
