<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Model\Car;
use App\Model\Serviceofcar;
use App\Model\Category;
use App\Model\Service;
use App\Model\Serviceofshop;
use App\Model\Shopofinfo;
class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $passing_data = array();
    public function index()
    {
        //
        

    }   

    /*
     -----------------------------------------------------------------------------------
     | Add new car informations to car table.                                           |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       year: string,  make:string,  term:string,  model:string, cylinder:string   |
     | @return                                                                          |
     |       bool (if success return true, if fail return false)                        |
     -----------------------------------------------------------------------------------
     */
    public function store(Request $request)
    {
        //
        $rules = [
        
          'year'       => 'required',
          'make'       => 'required',
          'model'      => 'required',
          'term'       => 'required',
          'cylinder'   => 'required'
              
        ];
        $this->validate($request, $rules);
           
        $year  = isset($request->year) ? $request->year : null;
        $make  = isset($request->make) ? $request->make : null;
        $model = isset($request->model) ? $request->model : null;
        $term  = isset($request->term) ? $request->term : null;
        $cylinder  = isset($request->cylinder) ? $request->cylinder : null;

        $data = array(

            'year'      => $year,
            'make'      => $make,
            'model'     => $model,
            'term'      => $term,
            'cylinder'  => $cylinder
        );

        return Car::insert($data);
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
     |       year : string,  make : string,  term : string,  model : string             |   
     | @return                                                                          |
     |       bool (if success return true, if fail return false)                        |
     -----------------------------------------------------------------------------------
     */
    public function update(Request $request, $id)
    {
        //
        $year  = isset($request->year) ? $request->year : null;
        $make  = isset($request->make) ? $request->make : null;
        $model = isset($request->model) ? $request->model : null;
        $term  = isset($request->term) ? $request->term : null;
        $cylinder  = isset($request->cylinder) ? $request->cylinder : null;

        $data = array(

            'year'      => $year,
            'make'      => $make,
            'model'     => $model,
            'term'      => $term,
            'cylinder'  => $cylinder
        );

        Car::updateCar($data, $id);

    }

    /*
     -----------------------------------------------------------------------------------
     | Delete givencar informations to car table.                                       |
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
        Car::deleteCar($id);
    }
    
    /*
     -----------------------------------------------------------------------------------
     | Get all car informations from car table.                                         |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       year : string,  make : string,  term : string,  model : string,            |          
     |       category_name : string                                                     |
     | @return                                                                          |
     |      array( shop_name : string, shop_zipcode : string, price :string)            |
     -----------------------------------------------------------------------------------
     */
    public function getCarList(Request $request) {
        $services = array();
        $distance_data = array();
        if($request){
           
            $point1 = $this->getLatLong($request->zip_code);
            $car_id = $request->car_id;
            $category_name = $request->category_name;
            /*
             *   current mileage store in session
             */
            session()->put('current_mileage', $request->current_mileage);  
           

              $category = Category::where('category_name', $category_name)->first();

              if(isset($category)){
                // find all sub category responding to inputed category name
                $car = Car::where('id', $car_id)->first();
                $service_id = Service::where('category_id', $category->id)->first()->id;

                // find all sub category responding to inputed category name
                $serviceofcar = Serviceofcar::where('car_id', $car_id)
                                            ->where('service_id', $service_id)
                                            ->first();
                if(!isset($serviceofcar)){
                    return "service";
                }
                $shopservices = Serviceofshop::where('serviceofshops.serviceofcar_id', '=', $serviceofcar->id)
                                            ->join('shopofinfos', 'serviceofshops.shopofinfos_id','shopofinfos.id')
                                            ->get();
                if(count($shopservices)==0){
                    return "shopservice";
                }else{
                     foreach($shopservices as $item) {
                       $point2 = $this->getLatLong($item['zip_code']);
                       array_push($distance_data, $this->distance($point1, $point2));
                       if($this->distance($point1, $point2) <= $request->distance) {
                            $data = array(
                            'category_name' => $category->category_name,
                            'shop_name'     => $item->shop_name,
                            'location'      => $this->getAddress($item['zip_code'], $blnUSA = true),
                            'shop_number'   => $item->shop_phonenumber,
                            'price'         => $item->total_price,
                            'description'   => $item->descriptions,
                            'year'          => $car->year,
                            'make'          => $car->make,
                            'model'         => $car->model,
                            'term'          => $car->term,
                            'rating'        => $item->rating,
                            'cylinder'      => $car->cylinder,
                            'serviceofshop_id' => $item->serviceofshop_id,
                            'latlong'  => $this->getLatLong($item['zip_code']),
                            'address'  => $this->fullAddress($item['zip_code']),
                            'distance' => $request->distance
                          );

                          array_push($services, $data);
                      }
                    }
                   if(count($services) == 0 ) return "exist";
                }
               
              }               
          

       }
       session()->put('viewModelData', $services );
     // return json_encode($distance_data);
      
    }
    public function fullAddress($zip){
        $url = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyCrVui1Yeur4NfiHuGWTSuFs1KBd9u8Jg4&address=".$zip."&sensor=false";
        $result_string = file_get_contents($url);
        $result = json_decode($result_string, true);
        return $result['results'][0]['formatted_address'];
    }
    /*
     *  calculate distance between two zip_codes.
     */
    public function distance($point1, $point2){
        $radius      = 3958;      // Earth's radius (miles)
        $deg_per_rad = 57.29578;  // Number of degrees/radian (for conversion)

        $distance = ($radius * pi() * sqrt(
                    ($point1['lat'] - $point2['lat'])
                    * ($point1['lat'] - $point2['lat'])
                    + cos($point1['lat'] / $deg_per_rad)  // Convert these to
                    * cos($point2['lat'] / $deg_per_rad)  // radians for cos()
                    * ($point1['lng'] - $point2['lng'])
                    * ($point1['lng'] - $point2['lng'])
            ) / 180);

        return $distance;  
    }
    /*
     *  get latitude and lognitude from zipcode
     */
    public function getLatLong($zip) {
        $url = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyCrVui1Yeur4NfiHuGWTSuFs1KBd9u8Jg4&address=".$zip."&sensor=false";
        $result_string = file_get_contents($url);
        $result = json_decode($result_string, true);
        return $result['results'][0]['geometry']['location'];
     
    }
    /*
     *   get address from zip code
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
    public function showResult() {
       
        $services = session()->get('viewModelData'); 
        $data = array(            
            'services' => $services
            
        );
        return View('partial.result')->with($data);
       // return json_encode($services);

    }

  
}
