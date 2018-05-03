<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Category extends Model
{
    //
    protected $table = 'categorys';	
	public $timestamps = true;	
	protected $fillable = [
	   'category_name','QTY'
	];
	/*
	 -----------------------------------------------------------------------------------
	 |  Set 1:1 relationship between service model and category model                   |
	 |----------------------------------------------------------------------------------
	 */
	public function service() {
		return $this->belongsTo('App\Model\Service');
	}
	/*
	 -----------------------------------------------------------------------------------
	 | Get category_id from category table by given category_name.                      |
	 |----------------------------------------------------------------------------------
	 | @param                                                                           |
	 |       category_name : string                                                     |
	 | @return                                                                          |
	 |       category_id :int                                                           |
	 -----------------------------------------------------------------------------------
	 */
	public static function findById($data) {
		if(isset($data)) {
			
			$category = DB::table('categorys')->where('category_name', $data)->first();

			if (!isset($category)) {

				echo "There is no such category";
				exit;
			}
			else {

				return $category->id;
			}		 
		}
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

   public static function insert($category_name, $QTY) {
	   	if (isset($category_name)) {   
	   		$parent_id = 0;          
	   	    foreach($category_name as $key=>$value){
		   		if(Category::check($value)) {
		   			$parent_id = Category::check($value);
		   			continue;
		   		}  		   			
	   			$old_id = DB::table('categorys')->max('id');
	   			$number = count($category_name);
	   			if($key == $number-1) $insert_QTY = $QTY; else $insert_QTY = 1;
	   			DB::table('categorys')->insert([
	   				 'category_name'      => $value,
					 'parent_id'		  => $parent_id,
					 'level'			  => $key+1,
					 'QTY'				  => $insert_QTY,
		             'created_at'		  => new \Datetime(),
		             'updated_at'		  => new \Datetime()
	   			]);

	   			$new_id = DB::table('categorys')->max('id');
	   			$parent_id = $new_id;
	   			if ($old_id < $new_id) {  			   		
	   				/* 
	   				 *   This part will be one which generated questions.
	   				 */
	   				if ($insert_QTY > 1 ){
	   					$questions = "How many tires to change ?" . "</br>". "How many total pentures to fix per tire?" ;
	   				}
	   				else{
	   					$questions = null;
	   				}
	   				DB::table('services')->insert(['category_id' => $new_id, 'questions' => $questions]);
	   				$service_id = DB::table('services')->max('id');	   				
	   				
	   			}
	   			
		   		
		   	}
		   	return "success";

	   	 }
   }
  /*
   -----------------------------------------------------------------------------------
   | check if new car informations exist on car table or not.                         |
   |----------------------------------------------------------------------------------
   | @param                                                                           |
   |       year: string,  make:string,  term:string,  model:string, cylinder:string   |
   | @return                                                                          |
   |       bool (if exist return true, if empty return false)                         |
   -----------------------------------------------------------------------------------
   */
   public static function check($data) {

	   	$category = DB::table('categorys')->where('category_name', $data)->first();   					
	   							
	   	if (!isset($category)) {
	   		return false;
	   	}
	   	else{
	   		return $category->id;
	   	}

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
	public static function findMainCategory(){

		$mainservices = Category::where('level', 1)->get();
		$category = array();
		foreach($mainservices as $item) {

			array_push($category, $item->category_name);

		}

		return $category;

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
	public static function findSubCategory($category_name){

		$category = Category::where('category_name', $category_name)->first();
		$subcategory = Category::where('level', '>', $category->level)->get();		
	 	$category_data = array();
	 	for($i = 0; $i < count($subcategory); $i++) {

		 		if ( $subcategory[$i]->parent_id == $category->id) array_push($category_data, $subcategory[$i]->category_name);
		}
	 	if(count($category_data) == 0) {

	 		return null;
	 	}
	 	else{
	 		return $category_data;

	 	}
		
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
	public static function checkSubCategory($category_name){

		$id = Category::where('category_name', $category_name)->first()->id;
		$subcategory = Category::where('level', '>', 1)->get();
		$category = array();
		for($i = 0; $i < count($subcategory); $i++) {

			if ( $subcategory[$i]->parent_id == $id) array_push($category, $subcategory[$i]->category_name);
		}
		return $category;

	}



}
