<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Model\Car;
use App\Model\Serviceofcar;
use App\Model\Category;
use App\Model\Service;
use App\Model\Serviceofshop;
use App\Model\Shopofinfo;
use App\Model\Shopofuser;
use App\Model\Calendar;
use App\Model\Event;
use App\Model\Shophour;
use App\Services\GoogleService;
use App\Model\ShopBlockSchedule;
use App\Model\Subscriptionplan;
use App\Model\File;
use App\Model\Billing;
class ShopController extends Controller
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
     | Add new shop informations to shop table.                                         |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       shop_name: string,  zip_code:string                                        |
     | @return                                                                          |
     |       bool (if success return true, if fail return false)                        |
     -----------------------------------------------------------------------------------
     */
    public function store(Request $request)
    {
        //
        $rules = [
          'shop_name' => 'required',
          'zip_code'  => 'required',
          'phone_number' => 'required',
          'BAR_number'  => 'required',
          'EPA_number'  => 'required'              
        ];

        $this->validate($request, $rules);
           
        $shop_name = $request->shop_name;
        $zip_code  = $request->zip_code;
        $phone_number = $request->phone_number;
        $BAR_number  = $request->BAR_number;
        $EPA_number  = $request->EPA_number;
        $data = array(
           'shop_name' => $shop_name,
           'zip_code'  => $zip_code,
           'phone_number' => $phone_number,
           'BAR_number' => $BAR_number,
           'EPA_number' => $EPA_number
        );
       
        Shopofinfo::insert($data);
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

    /*
     -----------------------------------------------------------------------------------
     | Get all car informations from car table.                                         |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       shop_name : string,  zip_code : string                                     |   
     | @return                                                                          |
     |       bool (if success return true, if fail return false)                        |
     -----------------------------------------------------------------------------------
     */
    public function update(Request $request, $id)
    {
        //
        $shop_name  = isset($request->shop_name) ? $request->shop_name : null;
        $zip_code   = isset($request->zip_code ) ? $request->zip_code  : null;
        $phone_number = $request->phone_number;
        $BAR_number = $request->BAR_number;
        $EPA_number = $request->EPA_number;

        $data = array(
            'shop_name' => $shop_name,
            'zip_code'  => $zip_code,
            'shop_phonenumber' => $phone_number,
            'BAR_number' => $BAR_number,
            'EPA_number' => $EPA_number
        );
        Shopofinfo::updateShop($data, $id);
    }

    /*
     -----------------------------------------------------------------------------------
     | Delete given shop informations to shop table.                                    |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       id:int                                                                     |
     | @return                                                                          |
     |       bool (if success return true, if fail return false)                        |
     -----------------------------------------------------------------------------------
     */
    public function destroy($id)
    {
        //
        Shopofinfo::deleteShop($id);
    }

    /*
     -----------------------------------------------------------------------------------
     | Get all shop informations from shopofinfos table.                                |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |                                                                                  |
     | @return                                                                          |
     |      array( shop_name : string, shop_zipcode : string, price :string)            |
     -----------------------------------------------------------------------------------
     */
    public function getShopList() {

       return json_encode(Shopofinfo::getName());
      
    }
    
    /*
     -----------------------------------------------------------------------------------
     | Get all car years.                                                               |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |                                                                                  |
     | @return                                                                          |
     |      array(year:string)                                                          |
     -----------------------------------------------------------------------------------
     */
    public function editYear() {
        return view('partial.edityear');
    }

    /*
     -----------------------------------------------------------------------------------
     | Get all car makes from selected year on database car table.                      |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       array(year:string)                                                         |
     | @return                                                                          |
     |       array(make:string)                                                         |
     -----------------------------------------------------------------------------------
     */
    public function editMake(Request $request){

        $year = $request->year;
        $make = array();
        foreach ($year as $item) {
            $data = Car::findMakeByYear($item);
            foreach ($data as $car) {
                if(in_array($car, $make)) continue; else array_push($make, $car);
            }
        }
        session()->put('year', $year);
        session()->put('make', $make );
        
    }
    /*
     -----------------------------------------------------------------------------------
     | Get all car makes from selected year on database car table.                      |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       array(year:string)                                                         |
     | @return                                                                          |
     |       array(make:string)                                                         |
     -----------------------------------------------------------------------------------
     */
    public function getMakeByYear(Request $request){

        $year = $request->year;
        $make = array();
        $data = Car::findMakeByYear($year);
        foreach ($data as $car) {
                if(in_array($car, $make)) continue; else array_push($make, $car);
        }       
        return $make;
        
    }
    /*
     -----------------------------------------------------------------------------------
     | Get all car models from selected year and make on database car table.            |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       array(year:string, make:string)                                            |
     | @return                                                                          |
     |       array(model:string)                                                        |
     -----------------------------------------------------------------------------------
     */
    public function getModelByYear(Request $request){

        $year = $request->year;
        $make = $request->make;
        $cars = Car::where('year', $year)->where('make', $make)->get();
        $model = array();
        foreach($cars as $car){
            if(!in_array($car->model, $model)) array_push($model, $car->model);
        }
        return $model;
        
    }
    /*
     -----------------------------------------------------------------------------------
     | Get all car terms from selected year and make, model on database car table.      |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       array(year:string, make:string, model:string)                              |
     | @return                                                                          |
     |       array(term:string)                                                         |
     -----------------------------------------------------------------------------------
     */
    public function getTermByYear(Request $request){

        $year = $request->year;
        $make = $request->make;
        $model = $request->model;
        $cars = Car::where('year', $year)->where('make', $make)->where('model', $model)->get();
        $term = array();
        foreach($cars as $car){
            if(!in_array($car->term, $term)) array_push($term, $car->term);
        }
        return $term;
        //echo $model;
        
    }

     /*
     -----------------------------------------------------------------------------------
     | Get all car makes from selected year on database car table.                      |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       array(year:string)                                                         |
     | @return                                                                          |
     |      array( make:string)                                                         |
     -----------------------------------------------------------------------------------
     */
    public function getMake(){

        $make = session()->get('make');
        return view('partial.editmake', compact('make'));
    }

    /*
     -----------------------------------------------------------------------------------
     | Get all car model from selected year and make on database car table.             |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       array(year:string, make:string)                                            |
     | @return                                                                          |
     |       array(model:string)                                                        |
     -----------------------------------------------------------------------------------
     */
    public function editModel(Request $request){
     
       $make = $request->make;
       $year = session()->get('year');

       $data = array(
          'make' => $make,
          'year' => $year
       );

       session()->put('make', $make );

       

    }

     /*
     -----------------------------------------------------------------------------------
     | Get all car makes from selected year on database car table.                      |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       array(year:string, make:string)                                            |
     | @return                                                                          |
     |      array( model:string)                                                        |
     -----------------------------------------------------------------------------------
     */
    public function getModel(){
        $year =  session()->get('year');
        $make =  session()->get('make');
        $cars = array();
        
        foreach ($year as $item1) {
            foreach($make as $item2) {
                $car = Car::where('year', $item1)->where('make', $item2)->get();
                foreach($car as $item3){
                    $m_year = $item3['year'];
                    $m_make = $item3['make'];
                    $m_model= $item3['model'];
                    $data = array(
                        'year' => $m_year,
                        'make' => $m_make,
                        'model' => $m_model
                    );
                    if(!in_array($data, $cars)) array_push($cars, $data);

                }
            }
        }
        return view('partial.editmodel', compact('cars'));
       // echo json_encode($cars);
    }

    /*
     -----------------------------------------------------------------------------------
     | Get all car model from selected year and make on database car table.             |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       array(year:string, make:string)                                            |
     | @return                                                                          |
     |       array(model:string)                                                        |
     -----------------------------------------------------------------------------------
     */
    public function editTerm(Request $request){

     
     $model = $request->model;
     $year =  session()->get('year');
     $make =  session()->get('make');
     $cars = array();
     $model_data = array();
     foreach($model as $item) {
        if(!in_array($item, $model_data)) array_push($model_data,  $item);
     }
     foreach($year as $item1){
        foreach($make as $item2) {
            foreach($model_data as $item3){
                $car = Car::where('year', $item1)
                          ->where('make', $item2)
                          ->where('model', $item3)->get();
               
                foreach($car as $item){
                    $m_year = $item['year'];
                    $m_make = $item['make'];
                    $m_model= $item['model'];
                    $m_term = $item['term'];
                    $id = $item['id'];
                    $data = array(

                        'id'  => $id,
                        'year' => $m_year,
                        'make' => $m_make,
                        'model' => $m_model,
                        'term' => $m_term
                    );
                    if(!in_array($data, $cars)) array_push($cars, $data);
                }
            }
        }
     }
     session()->put('model', $model_data);
     session()->put('viewTermData', $cars);    

    }

    /*
     -----------------------------------------------------------------------------------
     | Get all car makes from selected year on database car table.                      |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       array(year:string, make:string)                                            |
     | @return                                                                          |
     |      array( model:string)                                                        |
     -----------------------------------------------------------------------------------
     */
    public function getTerm(){
        $cars = session()->get('viewTermData');        
        $currentPage = LengthAwarePaginator::resolveCurrentPage()-1;
        //Create a new Laravel collection from the array data
        $collection = new Collection($cars);
        //Define how many items we want to be visible in each page
        $perPage = 6;        
        //Slice the collection to get the items to display in current page
        $currentPageSearchResults = $collection->slice($currentPage * $perPage, $perPage)->all();
        //Create our paginator and pass it to the view
        $paginatedCarResults= new LengthAwarePaginator($currentPageSearchResults, count($collection), $perPage);
        // if ($request->ajax()) {
        //     return view('partial.car', compact('cars'));
        // }

        return view('partial.editterm', ['cars' => $paginatedCarResults]);
        //echo json_encode($paginatedCarResults['data']);
        
    }

    public function editCategory(Request $request){
        
        $term = $request->term;
        session()->put('term', $term);
        return json_encode(session()->get('term'));
    }

    public function getCategory(){
        $categorys = Category::findMainCategory();
        return view('partial.category', compact('categorys'));

    }
    /*
     *   shop calendar addition and show
     */
    public function showProfile() {

        $user_id = Auth::user()->id;
        $user_calendar = Calendar::where('user_id', $user_id)->first();
        if(!isset($user_calendar)) {
            Calendar::create($user_id);
        }
      
        return view('pages.shoppage.calendar');
    }

    /*
     *  shopowner schedule page show
     */

    public function getSchedule() {
        $user_id = Auth::user()->id;
        $shop_user = Shopofuser::where('user_id', $user_id)
                               ->join('shopofinfos','shopofusers.shopofinfo_id', 'shopofinfos.id')->first();
        $events = Event::where('shop_id', $shop_user['shopofinfo_id'])->get();
        $data = array(
            'events' => $events
        );
        return View('pages.shoppage.schedule')->with($data);
        //return json_encode($events);
    }
    /*
     *  shopowner profile page show
     */

    public function getProfile() {

        $user_id = Auth::user()->id;
        $shop_user = Shopofuser::where('user_id', $user_id)
                  ->join('shopofinfos','shopofusers.shopofinfo_id', 'shopofinfos.id')->first();
        $zip_code = $shop_user->zip_code;
        $street_address = $shop_user->address;
        $city = $shop_user->city;
        $state = $shop_user->state;

        // get shop hour 
        $shop_id = Shopofuser::where('user_id', $user_id)->first()->shopofinfo_id;
        $shophour = Shophour::where('shopofinfo_id', $shop_id)->get();
        $shopblocktimes = ShopBlockSchedule::where('shopofinfo_id', $shop_id)->get();  

        // // // check plan status
        // $subscription_plan = Subscriptionplan::where('shopofinfo_id', $shop_id)->first();   
        // switch ($subscription_plan['status']) {
        //     case '0':
        //         $plan = "No Active";
        //         break;
        //     case '1':
        //         $plan = "Active";
        //         break;
        //     case '2':
        //         $plan = "Expire";
        //         break;     
        // }
        // check insurance and license
        $file = File::where('user_id', $user_id)->get();
        // foreach ($file as $item) {
        //    if($file['file_type'] == 0 ) {
        //      switch ($file['status']) {
        //          case '0':
        //             $insurance_status = "Processing";
        //              break;
        //          case '1':
        //             $insurance_status = "Valid";
        //              break;
        //          case '2':
        //             $insurance_status = "Need re-certification";
        //              break;         
        //      }
        //    }
        //    if($file['file_type'] == 1 ) {
        //      switch ($file['status']) {
        //          case '0':
        //             $license_status = "Processing";
        //              break;
        //          case '1':
        //             $license_status = "Valid";
        //              break;
        //          case '2':
        //             $license_status = "Need re-certification";
        //              break;         
        //      }
        //    }
        // }


        $data = array(
            'street' => $street_address,
            'city' => $city,
            'state' => $state,
            'zip_code' => $zip_code,             
            'shop_user' => $shop_user,
            'hours' => $shophour,
            'shopblocktimes' => $shopblocktimes,
            'file' => $file
           
        );
        return View('pages.shoppage.myprofile')->with($data);
     
      // return $address_result;
       // return $full_address;
       
    }

    /*
     *   shop info edit
     */

    public function editShopInfo($id) {
       
        $zip_code = Shopofinfo::where('id', $id)->first()->zip_code;
        $phone_number = Shopofinfo::where('id', $id)->first()->shop_phonenumber;        
        $street_address = Shopofinfo::where('id', $id)->first()->address;
        $city = Shopofinfo::where('id', $id)->first()->city;
        $state = Shopofinfo::where('id', $id)->first()->state;
       
        $data = array(
            'province' => $state,
            'city'     => $city,
            'street'   => $street_address,
            'postal_code' => $zip_code,           
            'phone_number' => $phone_number,
            'id' => $id
        );
        return View('pages.shoppage.shopinfo')->with($data);
    }
    /*
     *   shopinfo update
     */
    public function updateShopInfo (Request $request) {
        $street = $_POST['street'];
        $city = $_POST['city'];
        $province = $_POST['province'];
        $postal_code = $_POST['postal_code'];
        $phone_number = $_POST['phone_number'];
        $id = $_POST['id'];
        $data = array(
            'street' => $street,
            'city' => $city,
            'province' => $province,
            'postal_code' => $postal_code
        );
        
        $address =$this->googleservice->checkFullAddress(urlencode($street.", ".$city.", ".$province.$postal_code));
        if(!isset($address)) {
            echo "Please input valid address";
        }else{
             if($address != 'Invalid address') {
                    Shopofinfo::where('id', $id)->update([
                        'zip_code' => $postal_code,
                        'shop_phonenumber' => $phone_number
                    ]);

                    return redirect('/shop/profile');
                }else{
                    echo "Please input valid address";
                }
        }
       
        

    }
    /*
     *   shop info edit
     */

    public function editShopHour($id) {
      $shophour = Shophour::where('shopofinfo_id', $id)->get();
      $data = array(
        'shophours' => $shophour,
        'id' => $id
      );

      return View('pages.shoppage.shophour')->with($data);
       // return $disclaimer;
    }
    public function updateShopHour(Request $request) {
        
        $id = $_POST['id'];
        $open_time[0] = isset($_POST['open_time0'])? $_POST['open_time0'] : '12:00 AM';
        $close_time[0] = isset($_POST['close_time0'])? $_POST['close_time0'] : '12:01 AM';
        $open_time[1] = isset($_POST['open_time1'])? $_POST['open_time1'] : '12:00 AM';
        $close_time[1] = isset($_POST['close_time1'])? $_POST['close_time1'] : '12:01 AM';
        $open_time[2] = isset($_POST['open_time2'])? $_POST['open_time2'] : '12:00 AM';
        $close_time[2] = isset($_POST['close_time2'])? $_POST['close_time2'] : '12:01 AM';
        $open_time[3] = isset($_POST['open_time3'])? $_POST['open_time3'] : '12:00 AM';
        $close_time[3] = isset($_POST['close_time3'])? $_POST['close_time3'] : '12:01 AM';
        $open_time[4] = isset($_POST['open_time4'])? $_POST['open_time4'] : '12:00 AM';
        $close_time[4] = isset($_POST['close_time4'])? $_POST['close_time4'] : '12:01 AM';
        $open_time[5] = isset($_POST['open_time5'])? $_POST['open_time5'] : '12:00 AM';
        $close_time[5] = isset($_POST['close_time5'])? $_POST['close_time5'] : '12:01 AM';
        $open_time[6] = isset($_POST['open_time6'])? $_POST['open_time6'] : '12:00 AM';
        $close_time[6] = isset($_POST['close_time6'])? $_POST['close_time6'] : '12:01 AM';
        $shopinfo = Shophour::where('shopofinfo_id', $id)->first();
        if(isset($shopinfo)){
           for($i = 0; $i < 7; $i++) {
            Shophour::where('shopofinfo_id', $id)->where('dayofweek', $i)->update([
                'open_time' => $open_time[$i],
                'close_time' => $close_time[$i],
                'updated_at' => date('Y-m-d H:i:s', strtotime('now'))
            ]);

           }
        }
        else{
          for($i = 0; $i < 7; $i++) {
            
            Shophour::insert([
              'open_time' => $open_time[$i],
              'close_time' => $close_time[$i],
              'shopofinfo_id' => $id,
              'dayofweek' =>$i,
              'created_at' => date('Y-m-d H:i:s', strtotime('now')),
              'updated_at' => date('Y-m-d H:i:s', strtotime('now'))
            ]);

          }          
        }
       
       return redirect('/shop/profile');

       // return $request->all();
    }
    /*
     *   shop disclaimer edit
     */

    public function editShopDisclaimer($id) {
        $disclaimer = Shopofinfo::where('id', $id)->first()->shop_declaimer;
        $data = array(
            'shopdisclaimer' => $disclaimer,
            'id' => $id
        );
        return View('pages.shoppage.shopdisclaimer')->with($data);
    }
    /*
     *   shop disclaimer edit
     */
    public function updateShopDisclaimer (Request $request){
        $disclaimer = $_POST['shopdisclaimer'];
        $id = $_POST['id'];
        Shopofinfo::where('id', $id)->update([
                        'shop_declaimer' => $disclaimer
                       
        ]);
        return redirect('/shop/profile');
    }
    /*
     *   shop info edit
     */

    public function editShopBlockSchedule($id) {
        $shopblockschedule = ShopBlockSchedule::all();
        $user_id = Auth::user()->id;
        $shop_id = Shopofuser::where('user_id', $user_id)->first()->shopofinfo_id;      
        $send_data = array();  
        foreach($shopblockschedule as $item){
          if($shop_id == $item['shopofinfo_id']){
              array_push($send_data, $item);
          }
        }
        $data = array(
            'shopblockschedule' => $send_data,
            'shop_id' => $id
        );
        return View('pages.shoppage.shopblockschedule')->with($data);
        //return json_encode($shopblockschedule);
    }

    public function alwaysBlockUpdate(Request $request) {
        $data = $request->all();
        ShopBlockSchedule::blockupdate($data);
        return json_encode(['status' => true]);
       // return json_encode($data);
    }
    public function alwaysBlockDelete(Request $request) {
        $id = $request->id;
        ShopBlockSchedule::where('shopblockschedule_id', $id)->delete();
        return json_encode(['status' => true]);
       // return json_encode($data);
    }
    public function onetimeBlockUpdate(Request $request) {
        $data = $request->all();
        ShopBlockSchedule::blockupdate($data);
        return json_encode(['status' => true]);
       // return json_encode($data);
    }
     public function onetimeBlockDelete(Request $request) {
        $id = $request->id;
        ShopBlockSchedule::where('shopblockschedule_id', $id)->delete();
        return json_encode(['status' => true]);
       // return json_encode($data);
    }
    /*
     * Always shop block
     */

    public function alwaysBlock(Request $request) {

        $all_data = $request->all();
        ShopBlockSchedule::insert($all_data);
        return json_encode(['status' => true]);

    }

    /*
     * Always shop block
     */

    public function onetimeBlock(Request $request) {

        $all_data = $request->all();
        ShopBlockSchedule::onetimeInsert($all_data);
        return json_encode(['status' => true]);

    }
 
    public function shopSubscription () {
        $user_id = Auth::user()->id;
        $shopinfo_id = Shopofuser::where('user_id', $user_id)->first();
        $shopinfo = Subscriptionplan::where('shopofinfo_id', $shopinfo_id['shopofinfo_id'])->first();
        $billing = Billing::where('shopofinfo_id', $shopinfo_id['shopofinfo_id'])->get();
        $send_data = array(
            'subscription_plan' => $shopinfo,
            'billing' => $billing           
        );
        
       return View('pages.shoppage.ownersubscription')->with($send_data);

       // echo json_encode($shopinfo_id);
       // exit;
    }  


    public function getUpload() {
        return view('pages.shoppage.fileupload');
    }
  
  
}
