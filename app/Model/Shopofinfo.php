<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Model\Car;
use App\Model\Serviceofcar;
use App\Model\Category;
use App\Model\Service;
use App\Model\Serviceofshop;
use App\Model\Shopofinfo;
class Shopofinfo extends Model
{
    //
    protected $table = 'shopofinfos';	
    public $timestamps = false;
	protected $fillable = [
	   'shop_name',
	   'zip_code',
        'shop_phonenumber',
        'BAR_number',
        'EPA_number'
	  
	];
	/*
	 -----------------------------------------------------------------------------------
	 |  Set 1:n relationship between shopofinfo model and serviceofshop model           |
	 |----------------------------------------------------------------------------------
	 */
	public function serviceofshop() {
		return $this->belongsToMany('App\Model\Serviceofshop');
	}

    /*
     -----------------------------------------------------------------------------------
     | Get shop data from shopinfos table by given serviceofshop_id.                    |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       sericeofshop_id : int                                                      |
     | @return                                                                          |
     |      shop_name:string, zip_code:string                                           |
     -----------------------------------------------------------------------------------
     */
	public static function getNameById($id) {
		if(isset($id)) {
			$shop = DB::table('shopofinfos')->where('id', $id)->first();
			$data = array(

				'shop_name' => $shop->shop_name,
				'zip_code'  => $shop->zip_code
				
			);	

			return $data;						 
		}

	}
    /*
     -----------------------------------------------------------------------------------
     | Get all shop data from shopinfos table.                                          |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |                                                                                  |
     | @return                                                                          |
     |      shop_name:string, zip_code:string                                           |
     -----------------------------------------------------------------------------------
     */
	public static function getName() {
		
			$shops = DB::table('shopofinfos')->get();
			$shop_data = array();
			foreach($shops as $item) {
				$data = array(
					'shop_name' => $item->shop_name,
					'zip_code'  => $item->zip_code
				);
				array_push($shop_data, $data);	
			}

			return $shop_data;						 
		
	}
    /*
     -----------------------------------------------------------------------------------
     | Add new shop informations to shop table.                                         |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       shop_name: string,  zip_code:string 								   |
     | @return                                                                          |
     |       bool (if success return true, if fail return false)                        |
     -----------------------------------------------------------------------------------
     */

     public static function insert($data) {
     	if (isset($data)) {    

     		if(Shopofinfo::check($data)){
     			echo "That shop information exist in database already !";
     		}
     		else{
     			
     			$old_id = DB::table('shopofinfos')->max('id');
     			DB::table('shopofinfos')->insert([
     				'shop_name' => $data['shop_name'],
     				'zip_code'  => $data['zip_code'],
                         'shop_phonenumber' => $data['phone_number'],
                         'BAR_number' => $data['BAR_number'],
                         'EPA_number' => $data['EPA_number'],
     				'created_at'=> new \Datetime(),
     				'updated_at'=> new \Datetime()
     				
     			]);

     			$new_id = DB::table('shopofinfos')->max('id');

     			if ($old_id < $new_id) {

     				echo "The insertion of data is successed !";
     			}
     			else {

     				echo "The insertion of data is failed !";
     			}
     		}
     	}
     }
    /*
     -----------------------------------------------------------------------------------
     | Add new shop informations to shop table.                                         |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |       shop_name: string,  zip_code:string, id:int     			             |
     | @return                                                                          |
     |       bool (if success return true, if fail return false)                        |
     -----------------------------------------------------------------------------------
     */

     public static function updateShop($data, $id) {
     	if (isset($id)) {     			
     		$old_shop = DB::table('shopofinfos')->where('id', $id)->first();
     		DB::table('shopofinfos')->where('id', $id)->update([
     			'shop_name'      => $data['shop_name'],
     			'zip_code'       => $data['zip_code'],
                     'shop_phonenumber' => $data['shop_phonenumber'],
                    'BAR_number' => $data['BAR_number'],
                    'EPA_number' => $data['EPA_number'],                       
                    'updated_at'     => new \Datetime()
     		]);    
     		
     		$new_shop = DB::table('shopofinfos')->where('id', $id)->first();     				
     		if ($old_shop !== $new_shop) {

     			echo "The update of data is successed !";
     		}
     		else {

     			echo "The update of data is failed !";
     		}
     	
     	}
     }
     /*
     -----------------------------------------------------------------------------------
     | check if new shop informations exist on shop table or not.                       |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |      shop_name: string,  zip_code 							             |
     | @return                                                                          |
     |       bool (if exist return true, if empty return false)                         |
     -----------------------------------------------------------------------------------
     */
     public static function check($data) {

     	$shop = DB::table('shopofinfos')->where('shop_name', $data['shop_name'])
     							->where('zip_code', $data['zip_code'])->first();     							
     							
     	if (!isset($shop)) {
     		return false;
     	}
     	else{
     		return true;
     	}

     }
    /*
     -----------------------------------------------------------------------------------
     | Delete given shop informations to shop table.                                    |
     |----------------------------------------------------------------------------------
     | @param                                                                           |
     |      id : int 													   |
     | @return                                                                          |
     |       bool (if success return true, if fail return false)                        |
     -----------------------------------------------------------------------------------
     */

     public static function deleteShop($id) {
     	if (isset($id)) {     			
     			
     		DB::table('shopofinfos')->where('id', $id)->delete();	
     		
     		$new_shop = DB::table('shopofinfos')->where('id', $id)->first();    				
     		if (!isset($new_shop)) {

     			echo "The remove of data is successed !";
     		}
     		else {

     			echo "The remove of data is failed !";
     		}
     		
     	}
     }
}
