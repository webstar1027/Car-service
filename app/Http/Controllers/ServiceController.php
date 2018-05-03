<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
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
use App\Model\Subscriptionplan;
use Carbon\Carbon;
use App\User;
use DateTime;
use App\Notifications\ServiceBook as ServiceBookNotification;
use App\Notifications\ShopownerBook as ShopownerBookNotification;
use App\Notifications\ServiceStatusChange as ServiceStatusChangeNotification;
class ServiceController extends Controller
{
    protected $googleservice;
 
    public function __construct(GoogleService $googleservice)
    {
        $this->googleservice = $googleservice;
      
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /*
     -----------------------------------------------------------------------------------
     | Add new service categroy informations to service and category table.             |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       category: string,  sub_category:string,  ...                               |
     | @return                                                                          |
     |       bool (if success return true, if fail return false)                        |
     -----------------------------------------------------------------------------------
     */
    public function store(Request $request)
    {
        //
        $category_name = array();
        $category = $request->category;
        $sub_category = $request->sub_category;
        $sub2_category = $request->sub2_category;
        $sub3_category = $request->sub3_category;
        $sub4_category = $request->sub4_category;
        $QTY = $request->QTY;
        if(isset($category)) array_push($category_name, $category);
        if(isset($sub_category)) array_push($category_name, $sub_category);
        if(isset($sub2_category)) array_push($category_name, $sub2_category);
        if(isset($sub3_category)) array_push($category_name, $sub3_category);
        if(isset($sub4_category)) array_push($category_name, $sub4_category);


        if(isset($reuqest->sub_category)) array_push($category_name, $request->sub_category);
        if(isset($reuqest->sub2_category)) array_push($category_name, $request->sub2_category);
        if(isset($reuqest->sub3_category)) array_push($category_name, $request->sub3_category);
        if(isset($reuqest->sub4_category)) array_push($category_name, $request->sub4_category);
        $QTY = isset($QTY) ? $request->QTY:1;          
       
        return Category::insert($category_name, $QTY);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $category_name = $request->category_name;
        $level = $request->level;
        $parent_id = $request->parent_id;
        $QTY = $request->QTY;

        Category::where('id', $id)->update([
            'category_name' => $category_name,
            'level'         => $level,
            'parent_id'     => $parent_id,
            'QTY'           => $QTY
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
       
        if(isset($id)) {
            Category::where('id', $id)->delete();
        }
    }
    /*
     -----------------------------------------------------------------------------------
     | Get all car informations from car table.                                         |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       year : string,  make : string,  term : string,  model : string,            |          
     |       category_name : string                                                     |
     | @return                                                                          |
     |      array( category_name : string)                                              |
     -----------------------------------------------------------------------------------
     */
    public function getServiceList(Request $request) {

        if($request){
            $rules = [
              'year'            => 'required',
              'make'            => 'required',
              'model'           => 'required',
              'term'            => 'required'            
            ];
            $this->validate($request, $rules);           
            $car_data = array(
              'year'            => $request->year,
              'make'            => $request->make,
              'model'           => $request->model,
              'term'            => $request->term              
            );
            $car_id = Car::findById($car_data);         
            $service = Serviceofcar::findByCarId($car_id);
            return json_encode($service);     

       }
    }
    /*
     -----------------------------------------------------------------------------------
     | Get all services of given shop all table.                                        |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |         shop_id : int                                                            |
     | @return                                                                          |
     |      array( year:string, make:string, model:string, term:string, price:string,   |
     |            category_name:string)                                                 |
     -----------------------------------------------------------------------------------
     */
     public function getShopService(Request $request) {
       
       if ($request->shop_id) {
           $shop_id = $request->shop_id;
           return json_encode(Serviceofshop::getService($shop_id));
       }
      
    }

    /*
     -----------------------------------------------------------------------------------
     | Add new shop service to serviceofcar and serviceofshops.                         |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       category_name: string,  price:string, make:string, year:string, model:strin|
     |      g, term:string                                                              |
     | @return                                                                          |
     |       bool (if success return true, if fail return false)                        |
     -----------------------------------------------------------------------------------
     */
    public function insertShopService(Request $request) {

        if($request->category_name) {
            $rules = [
                  'year'            => 'required',
                  'make'            => 'required',
                  'model'           => 'required',
                  'term'            => 'required',                                
                  'category_name'   => 'required',                 
                  'price'           => 'required',
                  'descriptions'    => 'required'        
            ];
            $this->validate($request, $rules);
            
            $year = $request->year;
            $make = $request->make;
            $model = $request->model;
            $term = $request->term;
           
            $category_name = $request->category_name;
            $price = $request->price;
            $descriptions = $request->descriptions;
            /*
             *   This shop id can be loged in user's shopofinfo id
             */
            $shopofinfo_id = Shopofuser::where('user_id', Auth::user()->id)->first()->shopofinfo_id;
           
            $car_data = array(
                'year' => $year,
                'make' => $make,
                'model'=> $model,
                'term' => $term
               
            );

            $car_id = Car::findById($car_data);
            if($car_id == false) {
                return "car";
                exit;
            }
            $service = Category::where('categorys.category_name', '=', $category_name)
                                  ->join('services', 'categorys.id', 'services.category_id')->first();           
            $service_id = $service->id;
            $shopservice = Serviceofshop::where('serviceofcar_id', Serviceofcar::findById($car_id, $service_id))
                                        ->where('shopofinfos_id', $shopofinfo_id)->first();
            if(isset($shopservice)) {
                echo "service";
                exit;
            }
            else {

                $serviceofshop = new Serviceofshop;
                if (Serviceofcar::serviceCheck($car_id, $service_id ) != false) {

                        
                        $serviceofshop->serviceofcar_id = Serviceofcar::serviceCheck($car_id, $service_id );
                        $serviceofshop->shopofinfos_id = $shopofinfo_id;
                        $serviceofshop->price = $price;
                        $serviceofshop->descriptions = $descriptions;
                        $serviceofshop->save();

                }
                else{

                        $serviceofcar = new Serviceofcar;
                        $serviceofcar->car_id = $car_id;
                        $serviceofcar->service_id = $service_id;
                        $serviceofcar->save();
                        $serviceofcar_id = $serviceofcar->id;

                        $serviceofshop = new Serviceofshop;
                        $serviceofshop->serviceofcar_id = $serviceofcar_id;
                        $serviceofshop->shopofinfos_id = $shopofinfo_id;
                        $serviceofshop->price = $price;
                        $serviceofshop->descriptions = $descriptions;
                        $serviceofshop->save();
                }
                if($serviceofshop->id) echo "You registered service successfully";
                $serviceofshop_id = $serviceofshop->id;
            }

            // item stroe for estimate cost and type.
            $items = $request->item;
            foreach ($items as $item) {
                $itemtype_id = Itemtype::findById($item['itemtype']);
                $item_name = $item['itemname'];
                $item_description = $item['description'];
                $item_cost = $item['cost'];

                $data = array(
                    'serviceofshop_id'  => $serviceofshop_id,
                    'itemtype_id'       => $itemtype_id,
                    'item_name'         => $item_name,
                    'descriptions'      => $item_description,
                    'cost'              => $item_cost
                );

                Item::insert($data);
            }

        }

    }
    /*
     -----------------------------------------------------------------------------------
     | Add new shop service for multiple to serviceofshops ,item tables.                |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |      category_name: string,  price:string, make:array, year:array, model: array  |
     |      term:array, item: object                                                    |
     | @return                                                                          |
     |       bool (if success return true, if fail return false)                        |
     -----------------------------------------------------------------------------------
     */
    public function createShopService(Request $request) {
        // $year = session()->get('year');
        // $make = session()->get('make');
        // $model = session()->get('model');
        // $term = session()->get('term');
        // $car_id = array();   
        $category_name = $request->category_name;
        $parent_id = Category::where('category_name', $category_name)->first()->parent_id;
        $parent = Category::where('id', $parent_id)->first();
        if(isset($parent)) $parent_name = $parent->category_name; else $parent_name = null;

        /*
         *   limitation year get
         */

        $limit = Category::where('category_name', $category_name)->first();
        session()->put('limit', $limit);

        $price = $request->price;
        $item_type = $request->item_type;
        $description = $request->description;
        $item_number = $request->item_number;
        $query_index = $request->query_index;
        $price_type = Pricetype::all();
        $pricetype = array();
        foreach($price_type as $item) {
            array_push($pricetype, $item->pricetype_name);
        }
        $data = [
          // 'year' => $year,
          // 'make' => $make,
          // 'model'=> $model,
          // 'term' => $term,
          'category_name' => $category_name,
          'parent_name'  => $parent_name,
          'price' => $price,
          'description' => $description,
          'item_type' => $item_type,
          'item_number' => $item_number,
          'price_type'  => $pricetype,
          'query_index' => $query_index
        ];

        session()->put('category', $data);       
       
    }
    /*
     -----------------------------------------------------------------------------------
     | create given shop service to serviceofcar and serviceofshops.                    |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       category_name: string,  price:string, make:string, year:string, model:strin|
     |      g, term:string                                                              |
     | @return                                                                          |
     |       bool (if success return true, if fail return false)                        |
     -----------------------------------------------------------------------------------
     */
    public function multiServiceCreate(Request $request){

       
       $car = $request->car;
       $category_name = $request->category_name;
       $description = $request->description;
       $complete_time = $request->complete_time;
       $item_description = $request->item_description;
       $item_type = $request->item_type;
       $item_price = $request->item_price;
       $total_cost = $request->total_cost;      
       
       $masterservice_name = $request->masterservice_name;
       $service_schedule = $request->service_schedule;      
       session()->put('costs', $item_price);
       session()->put('total_cost', $total_cost);
       session()->put('description', $description);
       $shopofinfo_id = Shopofuser::where('user_id', Auth::user()->id)->first()->shopofinfo_id;
       $car_id = array();
       $shopservice_id = array();
       $updated_id = array();     
       $serviceofshop_id = null;  
       session()->put('masterservice_name', $masterservice_name);
       /**
        *    Store master service name to master table
        */
       Master::insert($masterservice_name);
       $master_id = DB::table('masters')->max('master_id');

       foreach($car as $item) {
         if(Car::findById($item) != false)  array_push($car_id, Car::findById($item));
       }
       $count = 0;
       foreach($car_id as $id) {
          $service = Category::where('categorys.category_name', '=', $category_name)
                        ->join('services', 'categorys.id', 'services.category_id')->first();                         
          $service_id = $service->id;   
          $shopservice = Serviceofshop::where('serviceofcar_id', Serviceofcar::findById($id, $service_id))
                                      ->where('shopofinfos_id', $shopofinfo_id)->first();
          if(isset($shopservice)) {
             
              Serviceofshop::where('serviceofshop_id', $shopservice->serviceofshop_id)->update([
                'total_price' => $total_cost[$count],
                'descriptions' => $description[$count],             
                'service_schedule' => $service_schedule,
                'complete_time' => $complete_time
              ]);
              array_push($shopservice_id, $shopservice->serviceofshop_id);
              array_push($updated_id, $shopservice->serviceofshop_id);
              $serviceofshop_id = $shopservice->serviceofshop_id;
          }
          else {
              $serviceofshop = new Serviceofshop;
              if (Serviceofcar::serviceCheck($id, $service_id ) != false) {                        
                  $serviceofshop->serviceofcar_id = Serviceofcar::serviceCheck($id, $service_id );
                  $serviceofshop->shopofinfos_id = $shopofinfo_id;
                  $serviceofshop->total_price = $total_cost[$count];
                  $serviceofshop->descriptions = $description[$count];
                  $serviceofshop->complete_time = $complete_time;                        
              
                  $serviceofshop->service_schedule = $service_schedule;
                  $serviceofshop->save();
                  $serviceofshop_id = $serviceofshop->id;
                  array_push($shopservice_id, $serviceofshop_id);
                  $this->insertMaster($master_id, $serviceofshop_id);
              }
              else{
                  $serviceofcar = new Serviceofcar;
                  $serviceofcar->car_id = $id;
                  $serviceofcar->service_id = $service_id;
                  $serviceofcar->save();
                  $serviceofcar_id = $serviceofcar->id;

                  $serviceofshop = new Serviceofshop;
                  $serviceofshop->serviceofcar_id = $serviceofcar_id;
                  $serviceofshop->shopofinfos_id = $shopofinfo_id;
                  $serviceofshop->price = $total_cost[$count];
                  $serviceofshop->descriptions = $description[$count];
                  $serviceofshop->complete_time = $complete_time;                               
                 
                  $serviceofshop->service_schedule = $service_schedule;
                  $serviceofshop->save();
                  $serviceofshop_id = $serviceofshop->id;
                  array_push($shopservice_id, $serviceofshop_id);
                  $this->insertMaster($master_id, $serviceofshop_id);
              }              
              
          }
          $category = session()->get('category');
          $query_index = $category['query_index'];
         // item stroe for estimate cost and type.   
          
          for($i = 0; $i < count($item_type); $i++){
             $itemtype_id = Pricetype::findById($item_type[$i]);
             $data = array(
                'serviceofshop_id'  => $serviceofshop_id,
                'itemtype_id'  => $itemtype_id,
                'item_description' => $item_description[$i],
                'item_price' => $item_price[$count][$i],
                'query_index' => $query_index
             );

             Price::insert($data);
          }  

         $count++; 

        }

       $id_data = array(
         'service_id' => $shopservice_id,
         'update_id'  => $updated_id
       );

       session()->put('id_data', $id_data);
       
    }  

    /*
     -----------------------------------------------------------------------------------
     | create masterserviceofshop table information.                                    |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |      master_id : int, serviceofshop_id : int                                     |
     | @return                                                                          |
     |      void                                                                        |
     -----------------------------------------------------------------------------------
     */

     public function insertMaster($id1, $id2) {
        Masterserviceofshop::insert($id1, $id2);
     }
    public function confirmCreate() {
      $costs = session()->get('costs');
      $total_cost = session()->get('total_cost');
      $description = session()->get('description');
      $id = Auth::user()->id;
      $flag = false;
      $services_data = array();
      $services = Shopofuser::where('shopofusers.user_id', '=',  $id)
                          ->join('serviceofshops', 'shopofusers.shopofinfo_id', 'serviceofshops.shopofinfos_id')
                          ->join('serviceofcars', 'serviceofshops.serviceofcar_id', 'serviceofcars.id')
                          ->join('cars', 'serviceofcars.car_id', 'cars.id')
                          ->join('services', 'serviceofcars.service_id', 'services.id')
                          ->join('categorys', 'services.category_id', 'categorys.id')->get();

      $id_data = session()->get('id_data');
      foreach($services as $item) {
        if(in_array($item['serviceofshop_id'], $id_data['service_id'])) {
            $status = 'Good';
            $flag = true;
        }
        if(in_array($item['serviceofshop_id'], $id_data['update_id'])) {
            $status = 'override pricing information of existing service';
            $flag = true;
        }

        if($flag == true) {
            $data = array(
                'id' => $item['serviceofshop_id'],
                'year' => $item['year'],
                'make' => $item['make'],
                'model' => $item['model'],
                'term' => $item['term'],
                'category_name' => $item['category_name'],                
                'complete_time' => $item['complete_time'],
                'service_schedule' => $item['service_schedule'],
                'total_price' => $item['total_price'],                
                'status'   => $status

            );
            array_push($services_data, $data);
            $flag = false;
        }
      }
      $services = array(
        'services_data' => $services_data,
        'costs' => $costs,
        'total_price' => $total_cost,
        'description' => $description,
        'masterservice_name' => session()->get('masterservice_name')
      );

     return View('partial.confirmservice')->with($services);
        // // $id_data = session()->get('id_data');
        // echo json_encode($costs);
        // exit;

    }
  
    /*
     -----------------------------------------------------------------------------------
     | create given shop service to selected car information and category name.         |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |                                                                                  |
     | @return                                                                          |
     |       view detailedit                                                            |
     -----------------------------------------------------------------------------------
     */
    public function detailPriceEdit() {
        $year = session()->get('year');
        $make = session()->get('make');
        $model = session()->get('model');        
        $term = array();
        $term = session()->get('term');
        $category = session()->get('category');
        $cars = array();
        foreach($year as $item1) {
            foreach ($make as $item2) {
                foreach($model as $item3) {
                    foreach($term as $item4) {
                        $car = Car::where('year', $item1)
                                  ->where('make', $item2)
                                  ->where('model', $item3)
                                  ->where('term', $item4)->first();
                       if(isset($car) && !in_array($car, $cars)) array_push($cars, $car);
                    }
                }
            }
        }

        /*
         *  Get Shopowner plan
         */ 
        $shopid = Shopofuser::where('user_id', Auth::user()->id)->first()->shopofinfo_id;
        $plan = Subscriptionplan::where('shopofinfo_id', $shopid)->first();
        $data = array(
          'cars' => $cars,
          'category' => $category,
          'plan' => $plan
        );
        return View('partial.detailedit')->with($data);
        // echo json_encode($category);
        // exit;
      
    }

    /*
     -----------------------------------------------------------------------------------
     | update given shop service to serviceofcar and serviceofshops.                    |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       category_name: string,  price:string, make:string, year:string, model:strin|
     |      g, term:string                                                              |
     | @return                                                                          |
     |       bool (if success return true, if fail return false)                        |
     -----------------------------------------------------------------------------------
     */
    public function updateShopService(Request $request) {

        $id = $request->id;
        $total_price = $request->total_price;
        $complete_time = $request->complete_time;
        $service_schedule = $request->service_schedule;
        $item_price = $request->item_price;
        Serviceofshop::where('serviceofshop_id', $id)->update([
            'total_price' => $total_price,
            'complete_time' => $complete_time,
            'service_schedule' => $service_schedule
        ]);   

        //item table update
        $price = Price::where('serviceofshop_id', $id)->get();
        $price_id = array();
        foreach($price as $item){
            array_push($price_id, $item->price_id);
        }
        for($i = 0; $i< count($price_id); $i++){
            Price::where('price_id', $price_id[$i])->update(['price' => $item_price[$i]]);
        }      
        $id_data = session()->get('id_data');
        if(in_array($id, $id_data['service_id'])){
           array_splice($id_data['service_id'], array_search($id, $id_data['service_id']), 1);           
           array_push($id_data['update_id'], $id);
        }
        session()->put('id_data', $id_data);

       // echo json_encode($item_price);


           
      
    }
    public function confirmUpdate(){
      session()->forget('costs');
      $id = Auth::user()->id;
      $flag = false;
      $services_data = array();     
      $total_cost = array();
      $services = Shopofuser::where('shopofusers.user_id', '=',  $id)
                              ->join('serviceofshops', 'shopofusers.shopofinfo_id', 'serviceofshops.shopofinfos_id')
                              ->join('serviceofcars', 'serviceofshops.serviceofcar_id', 'serviceofcars.id')
                              ->join('cars', 'serviceofcars.car_id', 'cars.id')
                              ->join('services', 'serviceofcars.service_id', 'services.id')
                              ->join('categorys', 'services.category_id', 'categorys.id')->get();

      $id_data = session()->get('id_data');
      foreach($services as $item) {
        if(in_array($item['serviceofshop_id'], $id_data['service_id'])) {
            $status = 'Good';
            $flag = true;
        }
        if(in_array($item['serviceofshop_id'], $id_data['update_id'])) {
            $status = 'override pricing information of existing service';
            $flag = true;
        }
        $items = Price::where('serviceofshop_id', $item['serviceofshop_id'])->get();
        $item_price = array();
        foreach($items as $item1){
           array_push($item_price, $item1->price);
        }
        array_push($total_cost, $item['total_price']);
       
        if($flag == true) {
            $data = array(
                'id' => $item['serviceofshop_id'],
                'year' => $item['year'],
                'make' => $item['make'],
                'model' => $item['model'],
                'term' => $item['term'],
                'category_name' => $item['category_name'],                
                'complete_time' => $item['complete_time'],
                'service_schedule' => $item['service_schedule'],               
                'status'   => $status

            );
            array_push($services_data, $data);
            $flag = false;
        }
      }
      $create_id = $id_data['service_id'];
      $update_id = $id_data['update_id'];
      $deal_id = array();
      foreach($create_id as $id1){
         if(!in_array($id1, $deal_id)) array_push($deal_id, $id1);
      }
      foreach($update_id as $id2){
         if(!in_array($id2, $deal_id)) array_push($deal_id, $id2);
      }
      $price = Price::all();

      $s_shop_id = array();
      foreach($price as $one){
        if(!in_array($one->serviceofshop_id, $s_shop_id) && in_array($one->serviceofshop_id, $deal_id)) array_push($s_shop_id, $one->serviceofshop_id);
      }
      $costs = array(count($s_shop_id));
      for($i = 0; $i < count($s_shop_id); $i++){
        $costs[$i] = array();
        $price = Price::where('serviceofshop_id', $s_shop_id[$i])->get();
        foreach($price as $item5) {
           array_push($costs[$i], $item5->price);
        }
      }
      $services = array(
        'services_data' => $services_data,
        'costs' => $costs,
        'total_price' => $total_cost
      );
      // echo json_encode($services_data);
      // exit;
      // echo json_encode($costs);
      // exit;
      return View('partial.confirmservice')->with($services);


    }
    // shopowner first page update service information
    public function updateService(Request $request){
         if($request->category_name) {           
            $year = $request->year;
            $make = $request->make;
            $model = $request->model;
            $term = $request->term;
            $cylinder = $request->cylinder;
            $category_name = $request->category_name;
            $price = $request->price;
            $descriptions = $request->descriptions;
            /*
             *   This shop id can be loged in user's shopofinfo id
             */
            $shopofinfo_id =  Shopofuser::where('user_id', Auth::user()->id)->first()->shopofinfo_id;
           
            $car_data = array(
                'year' => $year,
                'make' => $make,
                'model'=> $model,
                'term' => $term,
                'cylinder' => $cylinder
            );

            if(Car::findById($car_data) == false) {
                return "car";
                exit;
            }
            $car_id = Car::findById($car_data);

            $service = Category::where('categorys.category_name', '=', $category_name)
                                  ->join('services', 'categorys.id', 'services.category_id')->first();
            if(isset($service)) {
                $service_id = $service->id;
            }
            else{

                return "false";
                exit;
            }

            $serviceofcar_id = Serviceofcar::findById($car_id, $service_id);
            $serviceofshop_id = Serviceofshop::where('shopofinfos_id', $shopofinfo_id)->first()->serviceofshop_id;
            Serviceofshop::updateService($serviceofshop_id, $serviceofcar_id, $shopofinfo_id, $price, $descriptions);


        }

    }
    /*
     -----------------------------------------------------------------------------------
     | delete given shop service to serviceofcar and serviceofshops.                    |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       category_name: string,  price:string, make:string, year:string, model:strin|
     |      g, term:string                                                              |
     | @return                                                                          |
     |       bool (if success return true, if fail return false)                        |
     -----------------------------------------------------------------------------------
     */
    public function deleteShopService($id) {
        
        Serviceofshop::where('serviceofshop_id', $id)->delete();
        $id_data = session()->get('id_data');
        if(in_array($id, $id_data['service_id'])){
           array_splice($id_data['service_id'], array_search($id, $id_data['service_id']), 1);      
          
        }
        session()->put('id_data', $id_data);      

    }
    public function confirmDelete(){
       $id = Auth::user()->id;
      $flag = false;
      $services_data = array();     
      $services = Shopofuser::where('shopofusers.user_id', '=',  $id)
                              ->join('serviceofshops', 'shopofusers.shopofinfo_id', 'serviceofshops.shopofinfos_id')
                              ->join('serviceofcars', 'serviceofshops.serviceofcar_id', 'serviceofcars.id')
                              ->join('cars', 'serviceofcars.car_id', 'cars.id')
                              ->join('services', 'serviceofcars.service_id', 'services.id')
                              ->join('categorys', 'services.category_id', 'categorys.id')->get();

      $id_data = session()->get('id_data');
      foreach($services as $item) {
        if(in_array($item['serviceofshop_id'], $id_data['service_id'])) {
            $status = 'Good';
            $flag = true;
        }
        if(in_array($item['serviceofshop_id'], $id_data['update_id'])) {
            $status = 'override pricing information of existing service';
            $flag = true;
        }
        $items = Price::where('serviceofshop_id', $item['serviceofshop_id'])->get();
        $item_price = array();
        foreach($items as $item1){
           array_push($item_price, $item1->price);
        }
        $total_price = 0;
        foreach($item_price as $item2){
            $total_price = $total_price + intval($item2);
        }
        if($flag == true) {
            $data = array(
                'id' => $item['serviceofshop_id'],
                'year' => $item['year'],
                'make' => $item['make'],
                'model' => $item['model'],
                'term' => $item['term'],
                'category_name' => $item['category_name'],                
                'complete_time' => $item['complete_time'],
                'service_schedule' => $item['service_schedule'],
                'total_price' => $total_price,
                'status'   => $status

            );
            array_push($services_data, $data);
            $flag = false;
        }
      }
      $price = Price::all();
      $s_shop_id = array();
      foreach($price as $one){
        if(!in_array($one->serviceofshop_id, $s_shop_id)) array_push($s_shop_id, $one->serviceofshop_id);
      }
      $costs = array(count($s_shop_id));
      for($i = 0; $i < count($s_shop_id); $i++){
        $costs[$i] = array();
        $price = Price::where('serviceofshop_id', $s_shop_id[$i])->get();
        foreach($price as $item5) {
           array_push($costs[$i], $item5->price);
        }
      }
      $services = array(
        'services_data' => $services_data,
        'costs' => $costs
      );
      // echo json_encode($services_data);
      // exit;
      // echo json_encode($costs);
      // exit;
      return View('partial.confirmservice')->with($services);

    }

    public function confirmService(Request $request) {
    
        $data = array(
          'masterservice_name' => $request->masterservice_name,
          'number' => $request->childservice_number         
        );


        return View('partial.confirmfinish')->with($data);
      //return json_encode($request->all());
    }

    /*
     -----------------------------------------------------------------------------------
     | find main service from categorys table.                                          |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |                                                                                  |    
     | @return                                                                          |
     |       array(category_name: string)                                               |
     -----------------------------------------------------------------------------------
     */
    public function findMainService() {      

        return Category::findMainCategory();
       
    }
    /*
     -----------------------------------------------------------------------------------
     | find below level sub service from categorys table.                               |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       category_name: string                                                      |    
     | @return                                                                          |
     |       array(category_name: string)                                               |
     -----------------------------------------------------------------------------------
     */
    public function findSubService(Request $request) {   

      if($request->category_name) {  
        $subcategory = Category::findSubCategory($request->category_name);
        return $subcategory;
      }

       
    }

    /*
     -----------------------------------------------------------------------------------
     | register one service for all car which has the same cylinder module.             |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       cylinder: string, price:string, descriptions:string                        |    
     | @return                                                                          |
     |       array(category_name: string)                                               |
     -----------------------------------------------------------------------------------
     */
    public function insertServiceByCylinder(Request $request) {

        if ( isset($request->cylinder)) {

          $cylinder = $request->cylinder;
          $category_name = $request->category_name;
          $price = $request->price;
          $descriptions = $request->descriptions;
          $shopofinfo_id = $request->shopofinfo_id;// this can be authenticated user_id -> shopinfo_id
          $car_id = Car::findByCylinderId($cylinder);
          $service = Category::where('categorys.category_name', '=', $category_name)
                                ->join('services', 'categorys.id', 'services.category_id')->first();
          if(isset($service)) {
            $service_id = $service->id;
          }
          else{

            return "There is no service name !";
            exit;
          }

          foreach($car_id as $key=>$value){
            $shopservice = Serviceofshop::where('serviceofcar_id', Serviceofcar::findById($value, $service_id))                                        ->where('shopofinfos_id', $shopofinfo_id)->first();
            if(isset($shopservice)) {
              echo "You have registered that service alreay!";
              continue;
            }
            else {
              $serviceofshop = new Serviceofshop;
              if (Serviceofcar::serviceCheck($value, $service_id ) != false) {                            
                $serviceofshop->serviceofcar_id = Serviceofcar::serviceCheck($value, $service_id );
                $serviceofshop->shopofinfos_id = $shopofinfo_id;
                $serviceofshop->price = $price;
                $serviceofshop->descriptions = $descriptions;
                $serviceofshop->save();
              }
              else{

                $serviceofcar = new Serviceofcar;
                $serviceofcar->car_id = $value;
                $serviceofcar->service_id = $service_id;
                $serviceofcar->save();
                $serviceofcar_id = $serviceofcar->id;

                $serviceofshop = new Serviceofshop;
                $serviceofshop->serviceofcar_id = $serviceofcar_id;
                $serviceofshop->shopofinfos_id = $shopofinfo_id;
                $serviceofshop->price = $price;
                $serviceofshop->descriptions = $descriptions;
                $serviceofshop->save();
              }
              if($serviceofshop->id) echo "You registered". $serviceofshop->id."th service successfully";
            }

          }

        }

    }

    public function detailDelete($master_id, $id){
      
       Serviceofshop::where('serviceofshop_id', $id)->delete();
       return redirect('/master/detail/'.$master_id);
       

    }

    /*
     -----------------------------------------------------------------------------------
     | child servie update of selected master service                                   |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       line item price:int, total_price:int                                       |    
     | @return                                                                          |
     |       view shopowner                                                             |
     -----------------------------------------------------------------------------------
     */
    public function masterserviceUpdate(Request $request){
        $serviceofshop_id = $request->id;
        $total_price = $request->total_price;
        $item_price = $request->item_price;

        $data = [
           'serviceofshop_id' => $serviceofshop_id,
           'total_price' => $total_price,
           'item_price' => $item_price
        ];
        Serviceofshop::where('serviceofshop_id', $serviceofshop_id)->update(['total_price' => $total_price]);
        $prices = Price::where('serviceofshop_id', $serviceofshop_id)->get();
        $price_id = array();
        foreach($prices as $price) {
            array_push($price_id, $price->price_id);
        }
        $count = 0;
        foreach($price_id as $id) {
            Price::where('price_id', $id)->update(['price' => $item_price[$count]]);
            $count++;
        }

    }
    /*
     *   get shop detail page
     */

    public function shopinfoDetail($id) {
      $lineitems = Price::where('serviceofshop_id','=', $id)
                          ->join('pricetypes', 'prices.pricetype_id', 'pricetypes.pricetype_id')->get();
      //pricetype_name
      $items = array();
      //lineitem price
      $price = array();
      foreach($lineitems as $item){
        array_push($items, $item['pricetype_name']);
        $data = array(
            $item['pricetype_name'] => $item['price']

        );
        array_push($price, $data);
      } 
      //price option       
      $query_index = Price::where('serviceofshop_id','=', $id)->first()->query_id;
      // return view('partial.detailservice');
      $services = Serviceofshop::where('serviceofshop_id', $id)
                             ->join('shopofinfos', 'serviceofshops.shopofinfos_id', 'shopofinfos.id')
                             ->leftjoin('serviceofcars', 'serviceofshops.serviceofcar_id', 'serviceofcars.id')
                             ->leftjoin('cars', 'serviceofcars.car_id', 'cars.id')
                             ->leftjoin('services', 'serviceofcars.service_id', 'services.id')
                             ->leftjoin('categorys', 'services.category_id', 'categorys.id')->first();

      /*
       *   geolocation calculate module
       */
      $zip_code = $services->zip_code;
      
    

      $data = array(
        'lineitems'   => $lineitems,
        'query_index' => $query_index,
        'price'       => $price,
        'pricetype'   => $items,
        'address'     => $services['address'],
        'city'        => $services['city'],
        'state'       => $services['state'],
        'zip_code'    => $services['zip_code'],
        'services'    => $services
      );


      return View('partial.detailservice')->with($data);
      
      //return json_encode($data);
     
    }
     /*
      *   get full address
      */
     public function fullAddress($zip){
        $url = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyCrVui1Yeur4NfiHuGWTSuFs1KBd9u8Jg4&address=".$zip."&sensor=false";
        $result_string = file_get_contents($url);
        $result = json_decode($result_string, true);
        return $result['results'][0]['formatted_address'];
    }
    /*
     *  get city, state, country
     */
    public function getAddress($zipcode, $blnUSA = true){
        $url = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyCrVui1Yeur4NfiHuGWTSuFs1KBd9u8Jg4&address=" . $zipcode . "&sensor=true";

        $address_info = file_get_contents($url);
        $json = json_decode($address_info);
        $city = "";
        $state = "";
        $country = "";
        if (count($json->results) > 0) {
            //break up the components
            $arrComponents = $json->results[0]->address_components;

            foreach($arrComponents as $index=>$component) {
                $type = $component->types[0];

                if ($city == "" && ($type == "sublocality_level_1" || $type == "locality") ) {
                    $city = trim($component->short_name);
                }
                if ($state == "" && $type=="administrative_area_level_1") {
                    $state = trim($component->short_name);
                }
                if ($country == "" && $type=="country") {
                    $country = trim($component->short_name);

                    if ($blnUSA && $country!="US") {
                        $city = "";
                        $state = "";
                        break;
                    }
                }
                if ($city != "" && $state != "" && $country != "") {
                    //we're done
                    break;
                }
            }
        }
        $arrReturn = $city.', '.$state.$zipcode.', '.$country;
        return $arrReturn;
    }

    /*
     *    service action 
     */
    public function serviceAction(Request $request) {
        $action_id = $request->id;
        $action_name = $request->action;
        $master_id = $request->master_id;
        $data = array(
            'action_id' => $action_id,
            'action_name' => $action_name,
            'master_id' => $master_id
        );
        
        $user = User::where('id', Auth::user()->id)->first();
        $master = Master::where('master_id', $master_id)->first();
        $user->notify(new ServiceStatusChangeNotification($action_name, $master));     
        session()->put('service_action', $data);
    }
    /*
     *    service action confirm 
     */
    public function confirmAction() {
       $data = session()->get('service_action');
       $action_id = $data['action_id'];
       $master_id  = $data['master_id'];
       $masterservice = Masterserviceofshop::where('master_id', $master_id)->first();     
       $masterservice_name = Master::where('master_id', $master_id)->first()->master_service_name;   
       $lineitems = Price::where('serviceofshop_id','=', $masterservice['serviceofshop_id'])
                          ->join('pricetypes', 'prices.pricetype_id', 'pricetypes.pricetype_id')->get();
       $items = array();
       foreach($lineitems as $item){
          array_push($items, $item['pricetype_name']);
       }        

       $childservices = Masterserviceofshop::where('master_id', '=', $master_id)                              
                                           ->leftjoin('serviceofshops', 'masterserviceofshops.serviceofshop_id', 'serviceofshops.serviceofshop_id')
                                           ->leftjoin('serviceofcars', 'serviceofshops.serviceofcar_id', 'serviceofcars.id')
                                           ->leftjoin('cars', 'serviceofcars.car_id', 'cars.id')
                                           ->leftjoin('services', 'serviceofcars.service_id', 'services.id')
                                           ->leftjoin('categorys', 'services.category_id', 'categorys.id')->get();
       $service_array = array();
       foreach($childservices as $childservice){
          for($i = 0; $i < count($action_id); $i++) {
             if($childservice['serviceofshop_id'] == $action_id[$i]){
                array_push($service_array, $childservice);
             }
          }
            
        
       }
       $childitems = Masterserviceofshop::where('master_id', '=', $master_id)->get();
       $child_price = array();        
       foreach($childitems as $childitem){
          $item_price = array();
          $serviceofshop_id = $childitem->serviceofshop_id;
          $prices = Price::where('serviceofshop_id', $serviceofshop_id)->get();
          foreach($prices as $price){
              array_push($item_price, $price->price);
          }
          array_push($child_price, $item_price);

       }
       /**
        *   line item name get
        */

       $shopservice_id = Masterserviceofshop::where('master_id', '=', $master_id)->first()->serviceofshop_id;
       $lineitem_prices = Price::where('serviceofshop_id', $shopservice_id)->get();
       $line_name = array();
       foreach($lineitem_prices as $itemtype){
           $pricetype_name = Pricetype::where('pricetype_id', $itemtype->pricetype_id)->first()->pricetype_name;
           array_push($line_name, $pricetype_name);
       }
       
       $service_data = array(
          'masterservice_name' => $masterservice_name,
          'items' => $child_price,
          'childservices' => $service_array,
          'line_name' => $line_name,
          'action_name' => $data['action_name']
          
       );
       return View('partial.actionconfirm')->with($service_data);
   
    }

    /*
     *  confirm back
     */
    public function actionBack(){
        $data = session()->get('service_action');
        $master_id = $data['master_id'];
        return redirect('/master/detail/'.$master_id);
    }
    /*
     *  confirm finish
     */
    public function finishConfirm() {

       $data = session()->get('service_action');
       $action_name = $data['action_name'];
       switch ($action_name) {
        case 'renew':
          $current_date = date('Y-m-d H:i:s');
          foreach ($data['action_id'] as $id) {
            Masterserviceofshop::where('serviceofshop_id', $id)->update([
              'created_at' => $current_date,
              'status'     => 0
            ]);
               
          }

          break;
        case 'delete':
          foreach ($data['action_id'] as $id) {
            Serviceofshop::where('serviceofshop_id', $id)->delete();                   
          }

          break;
        case 'deactive':
          foreach ($data['action_id'] as $id) {
            Masterserviceofshop::where('serviceofshop_id', $id)->update([                    
              'status'     => 2
            ]);
          }
          break;           
       }
       return redirect('/shopowner');
    }

    /*
     *   Service expire making in background level
     */
    public function serviceExpire() {
        $current_date = date('Y-m-d');
        $services = Masterserviceofshop::all();
        $data = array();
        foreach($services as $service) {
            $create_date = date('Y-m-d', strtotime($service->created_at));
            $difference_date = date_diff(date_create($create_date), date_create($current_date))->format('%R%a');
            if($difference_date >= 10){
                Masterserviceofshop::where('masterserviceofshop_id', $service['masterserviceofshop_id'])->update(['status' => 1]);
            }
        }

        return "status is ok";
        
    }

    /**
     *  user book service
     *
     *  @var serviceofshop id
     */
    public function bookService ($id) {


        $shopavailable_time = session()->get('shop_available_time');       
        $option =  session()->get('shop_option');
        if(!isset($shopavailable_time)) $shopavailable_time = null;
        $data = array(
         'id' => $id,
         'shop_available_time' => $shopavailable_time,
         'option' => $option
        );
        session()->forget('shop_available_time');
        session()->forget('shop_option');
        return View('pages.userpage.bookappointment')->with($data);
    //  return json_encode($shopavailable_time);
       
    }

     public function shopserviceDetail($id) {
      $lineitems = Price::where('serviceofshop_id','=', $id)
                          ->join('pricetypes', 'prices.pricetype_id', 'pricetypes.pricetype_id')->get();
      //pricetype_name
      $items = array();
      //lineitem price
      $price = array();
      foreach($lineitems as $item){
        array_push($items, $item['pricetype_name']);
        $data = array(
            $item['pricetype_name'] => $item['price']

        );
        array_push($price, $data);
      } 
      //price option       
      $query_index = Price::where('serviceofshop_id','=', $id)->first()->query_id;
      // return view('partial.detailservice');
      $services = Serviceofshop::where('serviceofshop_id', $id)
                             ->join('shopofinfos', 'serviceofshops.shopofinfos_id', 'shopofinfos.id')
                             ->leftjoin('serviceofcars', 'serviceofshops.serviceofcar_id', 'serviceofcars.id')
                             ->leftjoin('cars', 'serviceofcars.car_id', 'cars.id')
                             ->leftjoin('services', 'serviceofcars.service_id', 'services.id')
                             ->leftjoin('categorys', 'services.category_id', 'categorys.id')->first();
      /*
       *   geolocation calculate module
       */

      $event = Event::where('shop_id', $services['shopofinfos_id'])
                    ->where('event_name', $services['category_name'])
                    ->where('car_id', $services['car_id'])->first();
      $zip_code = $services->zip_code;
      $fulladdress =  $this->googleservice->getStreetName($zip_code);     

      $data = array(
        'lineitems'   => $lineitems,
        'query_index' => $query_index,
        'price'       => $price,
        'pricetype'   => $items,
        'fulladdress' => $fulladdress,       
        'services'    => $services,
        'event'       => $event
      );


      return View('pages.userpage.detailservice')->with($data);
    //  return json_encode($data);
     
    }

   /**
    *  date and time available status window display
    * 
    *  @var weeknumber, serviceofshop id
    */

    public function postServiceAppoint(Request $request) {

      $week = explode('-', $request->weeknumber);
      $weeknumber = $week[1]; $weekyear = $week[0];
      $id = $request->id;
      $shopofinfo_id = Serviceofshop::where('serviceofshop_id', $id)->first()->shopofinfos_id;
      $complete_time = Serviceofshop::where('serviceofshop_id', $id)->first()->complete_time;

      $weekday = $this->getWeekday($weeknumber, $weekyear);
      $avialable_date_time = array();
      // factor 1 - shop hour and block time(open time and close time)
      $count = 0;
      $shophours = Shophour::where('shopofinfo_id', $shopofinfo_id)->get();      
      foreach($shophours as $hour){       
        $avialable_date_time [$weekday[$count++]] =  $hour['open_time']."-".$hour['close_time'];
      }         
      foreach($avialable_date_time as $key=>$value) {
        if ( ShopBlockSchedule::compareTime($key, $value, $shopofinfo_id) == "no block") {
          $avialable_date_time[$key] = $value;
        }   
        else{
          $avialable_date_time[$key] = ShopBlockSchedule::compareTime($key, $value, $shopofinfo_id);
        }         
      }
      // factor 2 - service complete time
      foreach($avialable_date_time as $key=>$value){
         $avialable_date_time[$key] = Serviceofshop::getAvailableTime($complete_time, $value);
      }
      // factor 3 - booked status check
      foreach($avialable_date_time as $key=>$value){
         $avialable_date_time[$key] = Serviceofshop::getBookTime($key, $value, $complete_time, $shopofinfo_id);

      }

      
      session()->put('shop_available_time',$avialable_date_time);
      session()->put('shop_option', $request->option);
     // return json_encode($avialable_date_time);
    
    }

    public function getWeekday($number, $year){
      $weekday = array();
      // a week date get from weeknumber    
      $dateTime = new DateTime();
      $dateTime->setISODate($year, $number);
      $weekday[0] = $dateTime->format('Y-m-d');
      for($day=1; $day<7; $day++)
      {
          $dateTime->modify('+1 day');
          $weekday[$day] = $dateTime->format('Y-m-d');
      }  
      return $weekday;
     
    }  

   /**
    *  user maintfy service appointment
    *
    *  @var service id, appoint date
    */

    public function serviceAppointment (Request $request) {

      $serviceofshop_id = $request->id;
      $date = $request->date;

      Event::serviceAppoint($serviceofshop_id, $date);
      $data = array(
        'id' => $serviceofshop_id,
        'date' =>  $date
      );
      session()->put('appoint_data', $data);   
      $user_id = Auth::user()->id;
      $user = User::where('id', $user_id)->first();
      $shop = Serviceofshop::where('serviceofshop_id', $serviceofshop_id)
                           ->join('shopofinfos', 'serviceofshops.shopofinfos_id', 'shopofinfos.id')
                           ->leftjoin('serviceofcars', 'serviceofshops.serviceofcar_id', 'serviceofcars.id')
                           ->leftjoin('cars', 'serviceofcars.car_id', 'cars.id')
                           ->leftjoin('services', 'serviceofcars.service_id', 'services.id')
                           ->leftjoin('categorys', 'services.category_id', 'categorys.id')->first();
      $user->notify(new ServiceBookNotification($shop));
      $shopinfo = Serviceofshop::where('serviceofshop_id', $serviceofshop_id)
                                ->join('shopofusers', 'serviceofshops.shopofinfos_id', 'shopofusers.shopofinfo_id')->first();
      $shopowner_id = $shopinfo->user_id;
      $shopowner = User::where('id', $shopowner_id)->first();
      $shopowner->notify(new ShopownerBookNotification($shop, $user));

    }

    public function confirmAppointment() {
    
      $appoint_data = session()->get('appoint_data');      
      $id = $appoint_data['id'];
      $lineitems = Price::where('serviceofshop_id','=', $id)
                        ->join('pricetypes', 'prices.pricetype_id', 'pricetypes.pricetype_id')->get();
      //pricetype_name
      $items = array();
      //lineitem price
      $price = array();
      foreach($lineitems as $item){
        array_push($items, $item['pricetype_name']);
        $data = array(
            $item['pricetype_name'] => $item['price']

        );
        array_push($price, $data);
      } 
      //price option       
      $query_index = Price::where('serviceofshop_id','=', $id)->first()->query_id;
      // return view('partial.detailservice');
      $services = Serviceofshop::where('serviceofshop_id', $id)
                             ->join('shopofinfos', 'serviceofshops.shopofinfos_id', 'shopofinfos.id')
                             ->leftjoin('serviceofcars', 'serviceofshops.serviceofcar_id', 'serviceofcars.id')
                             ->leftjoin('cars', 'serviceofcars.car_id', 'cars.id')
                             ->leftjoin('services', 'serviceofcars.service_id', 'services.id')
                             ->leftjoin('categorys', 'services.category_id', 'categorys.id')->first();

      /*
       *   geolocation calculate module
       */
      $event = Event::where('shop_id', $services['shopofinfos_id'])
                    ->where('event_name', $services['category_name'])
                    ->where('car_id', $services['car_id'])->first();
      $zip_code = $services->zip_code;
      $fulladdress =  $this->googleservice->getStreetName($zip_code);     

      $data = array(
        'lineitems'   => $lineitems,
        'query_index' => $query_index,
        'price'       => $price,
        'pricetype'   => $items,
        'fulladdress' => $fulladdress,       
        'services'    => $services,
        'event'       => $event,
        'date'        => $appoint_data['date']
      );
      return View('pages.userpage.bookingconfirm')->with($data);
    }

}
