<?php
namespace App\Services;

class GoogleService 
{
    public function __construct() {

    }
    public function fullAddress($zip){
        $url = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyCrVui1Yeur4NfiHuGWTSuFs1KBd9u8Jg4&address=".$zip."&sensor=false";
       
         $result_string = file_get_contents($url);
       
        if (!isset($result_string)) {
            return "false";
        }
        else{
             $result = json_decode($result_string, true);
             return $result['results'][0]['formatted_address'];
        }
      
    }
    /*
     *  get city, state, country
     */
    public function getAddress($zipcode, $blnUSA = true){
        $url = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyCrVui1Yeur4NfiHuGWTSuFs1KBd9u8Jg4&address=" . $zipcode . "&sensor=false";
        $address_info = file_get_contents($url);
        if(!isset($address_info)){

            return "false";
        }
        else{

            $json = json_decode($address_info);
            $city = "";
            $state = "";
            $country = "";
            if (count($json->results) > 0) {          
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
       
    }
 
  /*
   *  detail street get
   */
  public function getStreetName($zip){
     $url = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyCrVui1Yeur4NfiHuGWTSuFs1KBd9u8Jg4&address=".$zip."&sensor=false";       
     $result_string = file_get_contents($url);
     $result = json_decode($result_string, true);    
     return $this->Get_Address_From_Google_Maps($result['results'][0]['geometry']['location']['lat'], $result['results'][0]['geometry']['location']['lng']);
  }

  public function Get_Address_From_Google_Maps($lat, $lon) {

    $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lon&sensor=false";

    // Make the HTTP request
    $data = @file_get_contents($url);
    // Parse the json response
    $jsondata = json_decode($data,true);

    // If the json data is invalid, return empty array
    if (!$this->check_status($jsondata))   return array();

    $address = array(
        'country' => $this->google_getCountry($jsondata),
        'province' => $this->google_getProvince($jsondata),
        'city' => $this->google_getCity($jsondata),
        'street' => $this->google_getStreet($jsondata),
        'postal_code' => $this->google_getPostalCode($jsondata),
        'country_code' => $this->google_getCountryCode($jsondata),
        'formatted_address' => $this->google_getAddress($jsondata),
    );

    return $address;

 }

    /* 
    * Check if the json data from Google Geo is valid 
    */

 public function check_status($jsondata) {
        if ($jsondata["status"] == "OK") return true;
        return false;
  }

    /*
    * Given Google Geocode json, return the value in the specified element of the array
    */

  public function google_getCountry($jsondata) {
        return $this->Find_Long_Name_Given_Type("country", $jsondata["results"][0]["address_components"]);
  }
  public function google_getProvince($jsondata) {
        return $this->Find_Long_Name_Given_Type("administrative_area_level_1", $jsondata["results"][0]["address_components"], true);
  }
  public function google_getCity($jsondata) {
        return $this->Find_Long_Name_Given_Type("locality", $jsondata["results"][0]["address_components"]);
  }
  public function google_getStreet($jsondata) {
        return $this->Find_Long_Name_Given_Type("street_number", $jsondata["results"][0]["address_components"]) . ' ' . $this->Find_Long_Name_Given_Type("route", $jsondata["results"][0]["address_components"]);
  }
  public function google_getPostalCode($jsondata) {
        return $this->Find_Long_Name_Given_Type("postal_code", $jsondata["results"][0]["address_components"]);
  }
  public function google_getCountryCode($jsondata) {
        return $this->Find_Long_Name_Given_Type("country", $jsondata["results"][0]["address_components"], true);
  }
  public function google_getAddress($jsondata) {
        return $jsondata["results"][0]["formatted_address"];
  }

    /*
    * Searching in Google Geo json, return the long name given the type. 
    * (If short_name is true, return short name)
    */

  public function Find_Long_Name_Given_Type($type, $array, $short_name = false) {
        foreach( $array as $value) {
            if (in_array($type, $value["types"])) {
                if ($short_name)    
                    return $value["short_name"];
                return $value["long_name"];
            }
        }
  }


  /*
   *  validate full address if it exists or not from google map api
   */

  public function checkFullAddress($address){
    $url = 'http://maps.googleapis.com/maps/api/geocode/json?address=' . $address . '&sensor=false';
    $geocode = file_get_contents($url);
    $results = json_decode($geocode, true);
    if ($results['status'] == 'OK') {
      $lat = $results['results'][0]['geometry']['location']['lat'];
      $long = $results['results'][0]['geometry']['location']['lng'];
    } 
    if ($results['status'] == 'OK') {
      if (count($results['results']) > 1) {
         echo "Multiple address found";
      }
      if (count($results['results']) == 1) {
        if (isset($results['results'][0]['partial_match'])) {
          if ($results['results'][0]['partial_match']) {
            echo "This is a partially right address";
          }
        } else {
          echo "Valid address";
        }
      }
    } else {
      echo "Invalid address";
    }
  }

}
