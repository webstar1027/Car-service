<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();
Route::get('/', function () {
    return view('welcome');
})->middleware('guest');

Route::get('/shop_owner', 'HomeController@getShopOwner');
Route::get('/subscription', 'HomeController@getSubscription');
Route::get('/shopsignup', 'HomeController@shopRegister');
Route::get('/insurance/upload', 'HomeController@uploadInsurance')->name('get.upload');
Route::post('/insurance/upload', 'HomeController@postInsurance')->name('upload.file');
Route::get('/license/upload', 'HomeController@uploadLicense');
Route::post('/license/upload', 'HomeController@postLicense')->name('upload.license');
Route::post('/shop/register', 'UserController@registerShop')->name('shopowner.register');
Route::get('/shopowner/login', 'HomeController@getSign');
Route::post('/shopowner/login', 'Auth\LoginController@postSign')->name('shopowner.login');

/*
 *   Paypal payment integration
 */
Route::get('paywithpaypal', ['as' => 'addmoney.paywithpaypal', 'uses' => 'PaypalController@payWithPaypal']);
Route::post('paypal', ['as' => 'addmoney.paypal','uses' => 'PaypalController@postPaymentWithpaypal']);
Route::get('paypal', array('as' => 'payment.status','uses' => 'PaypalController@getPaymentStatus',));
/*
 *  service expire in background level
 */
Route::get('/service/status', ['as' => 'service.expire', 'uses' => 'ServiceController@serviceExpire']);
Route::group(['middleware' => ['auth', 'web', 'roles']], function () {

	/*
	 ****************************************************************
	 *  													   		*
	 *  This group dipaly route related to find service name        *
	 *														   		*
	 ****************************************************************
	 */	 
    Route::post('/find/service', ['as' => 'find.sub.category', 'uses' => 'ServiceController@findSubService']);
	Route::get('/find/service', ['as' => 'find.main.category', 'uses' => 'ServiceController@findMainService']);
    
	Route::group(['roles' => ["master"]], function() {

		//Route::get('/', 'UserController@showAdmin');
		 Route::get('/master', 'UserController@showAdmin');		 
		/*
		 ********************************************************
		 *  												    *
		 *  This group dipaly route related to car information  *
		 *													    *
		 ********************************************************
		 */

		Route::get('/admin/operator', ['as' => 'shop.operator', 'uses' => 'UserController@shopOperator']);
		Route::post('/operator/update', ['as' => 'operator.update', 'uses' => 'UserController@operatorUpdate']);
		Route::group(['prefix' => 'car'], function() {			 
			 	// Add new car information 
			 	Route::post('/insert', ['as' => 'car.insert', 'uses' => 'CarController@store']);
			 	// updata car information
			 	Route::put('/update/{id}', ['as' => 'car.update', 'uses' => 'CarController@update']);
			 	// updata car information
			 	Route::delete('/delete/{id}', ['as' => 'car.delete', 'uses' => 'CarController@destroy']);
		 });

		 /*
		 ***********************************************************
		 *  													   *
		 *  This group dipaly route related to service information *
		 *														   *
		 ***********************************************************
		 */
		 Route::group(['prefix' => 'service'], function() {

		 	
		 	// show registered service information 
		 	Route::post('/list', ['as' => 'service.list', 'uses' => 'ServiceController@getServiceList']);
		 	// Add new service information 
		 	Route::post('/insert', ['as' => 'service.insert', 'uses' => 'ServiceController@store']);

		 	// updata service information
		 	Route::put('/update/{id}', ['as' => 'service.update', 'uses' => 'ServiceController@update']);
		 	// updata service information
		 	Route::delete('/delete/{id}', ['as' => 'service.delete', 'uses' => 'ServiceController@destroy']);
		 });

		 	/*
			 ********************************************************
			 *  													*
			 *  This group dipaly route related to shop information *
			 *													    *
			 ********************************************************
			 */
			 Route::group(['prefix' => 'shop'], function() {			 	
			 	// show registered shop information 
			 	Route::get('/list', ['as' => 'shop.list', 'uses' => 'ShopController@getShopList']);
			 	// Add new shop information 
			 	Route::post('/insert', ['as' => 'shop.insert', 'uses' => 'ShopController@store']);
			 	// updata shop information
			 	Route::put('/update/{id}', ['as' => 'shop.update', 'uses' => 'ShopController@update']);
			 	// updata shop information
			 	Route::delete('/delete/{id}', ['as' => 'shop.delete', 'uses' => 'ShopController@destroy']);
			 });


	});
	Route::group(['roles' => ["shopowner"]], function() {		
		
		Route::get('/shopowner', array('as'=>'pagination', 'uses' =>'UserController@showShopOwner'));
		/*
		 ****************************************************************
		 *  													  		*
		 *  This group dipaly route related to shop service information *
		 *														   		*
		 ****************************************************************
		 */
		// select year
		Route::get('/year/edit', ['as' => 'year.edit', 'uses'=>'ShopController@editYear']);
        // select make
		Route::post('/find/make', ['as' => 'make.edit', 'uses' => 'ShopController@editMake']);
		Route::get('/find/make', ['as' => 'get.make', 'uses' => 'ShopController@getMake']);
        // select model
		Route::post('/find/model', ['as' => 'model.edit', 'uses' => 'ShopController@editModel']);
		Route::get('/find/model', ['as' => 'get.model', 'uses' => 'ShopController@getModel']);
        // select term
		Route::post('/find/term', ['as' => 'term.edit', 'uses' => 'ShopController@editTerm']);
		Route::get('/find/term', ['as' => 'get.term', 'uses' => 'ShopController@getTerm']);
        // select category
		Route::post('/find/category', ['as' => 'category.edit', 'uses' => 'ShopController@editCategory']);
		Route::get('/find/category', ['as' => 'get.category', 'uses' => 'ShopController@getCategory']);
        // detail edit price
        Route::get('/detail/price/edit', ['as' => 'detail.edit', 'uses' => 'ServiceController@detailPriceEdit']);
        // confirm multi-service
        Route::post('/multiserivce/create', ['as' => 'multiservice.create', 'uses' =>'ServiceController@multiServiceCreate']);
      
        Route::get('/multiserivce/create/confirm', ['as' => 'multiservice.create.confirm', 'uses' =>'ServiceController@confirmCreate']);

        Route::get('/multiserivce/update/confirm', ['as' => 'multiservice.update.confirm', 'uses' =>'ServiceController@confirmUpdate']);

        Route::get('/multiserivce/delete/confirm', ['as' => 'multiservice.delete.confirm', 'uses' =>'ServiceController@confirmDelete']);
        Route::get('/service/confirm', ['as' => 'service.confirm', 'uses' => 'ServiceController@confirmService']);
        Route::post('/service/shop/update', 'ServiceController@updateService');

        Route::get('/document/upload', 'ShopController@getUpload');
		Route::group(['prefix' => 'shop/service'], function() {

		 	
		 	// show registered shop information 
		 	Route::post('/list', ['as' => 'shop.service.list', 'uses' => 'ServiceController@getShopService']);
		 	// Add new service information 
		 	Route::post('/insert', ['as' => 'shop.service.insert', 'uses' => 'ServiceController@insertShopService']);
		 	// Add one service for multi car
		 	Route::post('/multicreate', ['as' => 'service.multicreate', 'uses' => 'ServiceController@createShopService']);
		 	// updata service information
		 	Route::post('/update', ['as' => 'shop.service.update', 'uses' => 'ServiceController@updateShopService']);
		 	// updata service information
		 	Route::delete('/delete/{id}', ['as' => 'shop.service.delete', 'uses' => 'ServiceController@deleteShopService']);

		 	// service register by cylinder module

		 	Route::post('/cylinder/insert', ['as' => 'cylinder.insert', 'uses' => 'ServiceController@insertServiceByCylinder']);

		});

		Route::get('/master/detail/{id}', ['as' => 'master.detail', 'uses' => 'UserController@detailMaster']);
        Route::get('/master/detail/{master_id}/delete/{id}', ['as' => 'detail.delete', 'uses' => 'ServiceController@detailDelete']);	
        Route::post('/master/service/update', ['as' => 'master.service.update', 'uses' => 'ServiceController@masterserviceUpdate']);	

        Route::post('/service/action', ['as' => 'service.action', 'uses' => 'ServiceController@serviceAction']);
        Route::get('/service/action/confirm', ['as' => 'action.confirm', 'uses' => 'ServiceController@confirmAction']);
        Route::get('/action/confirm/back', ['as' => 'action.back', 'uses' => 'ServiceController@actionBack']);
        Route::get('/acion/confirm/finish', ['as' => 'confirm.finish', 'uses' => 'ServiceController@finishConfirm']);
        
        Route::get('/shopprofile', ['as' => 'shop.profile', 'uses' => 'ShopController@showProfile']);

        /*
         *   shop owner schedule page.
         */
        Route::get('/shop/schedule', ['as' => 'shop.schedule', 'uses' => 'ShopController@getSchedule']);
        /*
         *   shop owner profile page
         */

        Route::get('/shop/profile', ['as' => 'shop.profile', 'uses' => 'ShopController@getProfile']);

        Route::get('/shop/info/edit/{id}', ['as' => 'shopinfo.edit', 'uses'=>'ShopController@editShopInfo']);
        Route::get('/shop/hour/edit/{id}', ['as' => 'shophour.edit', 'uses'=>'ShopController@editShopHour']);
        Route::get('/shop/disclaimer/edit/{id}', ['as' => 'shopdisclaimer.edit', 'uses'=>'ShopController@editShopDisclaimer']);
        Route::get('/shop/block_schedule/edit/{id}', ['as' => 'shopblock.edit', 'uses'=>'ShopController@editShopBlockSchedule']);
        
        /*
         *  validate if shopinfo is true from google map api
         */
        Route::post('/shop/info/update', 'ShopController@updateShopInfo');
        Route::post('/shop/disclaimer/update', 'ShopController@updateShopDisclaimer');
        Route::post('/shop/hour/update', 'ShopController@updateShopHour');

        Route::post('/shop/block/always', ['as'=>'always.block', 'uses'=>'ShopController@alwaysBlock']);
        Route::post('/shop/block/onetime', ['as'=>'onetime.block', 'uses'=>'ShopController@onetimeBlock']);

        /*
         * shop block time update and delete
         */
        Route::post('/shop/block/always/update', ['as'=>'always.block.update', 'uses'=>'ShopController@alwaysBlockUpdate']);
        Route::post('/shop/block/onetime/update', ['as'=>'onetime.block.update', 'uses'=>'ShopController@onetimeBlockUpdate']);
        Route::post('/shop/block/always/delete', ['as'=>'always.block.delete', 'uses'=>'ShopController@alwaysBlockDelete']);
        Route::post('/shop/block/onetime/delete', ['as'=>'onetime.block.delete', 'uses'=>'ShopController@onetimeBlockDelete']);
        Route::get('/shop/subscription', 'ShopController@shopSubscription');

	});
	Route::group(['roles' => ["user"]], function() {
			//Route::get('/', 'UserController@showUser');
			Route::get('/user', 'UserController@showUser');		
			Route::get('/usermain', 'UserController@showUserMain');
			// get registered service list
			Route::post('/service/search', ['as' => 'car.list', 'uses' => 'CarController@getCarList']);
			Route::get('/search/service', ['as' => 'result.show', 'uses' => 'CarController@showResult']);
			Route::get('/search/back', ['as' => 'search.back', 'uses' => 'UserController@goBack']);
			// find make responding to selected year
			Route::post('/get/make', 'ShopController@getMakeByYear');
			// find make responding to selected year and make
			Route::post('/get/model', 'ShopController@getModelByYear');
			// find make responding to selected year and make
			Route::post('/get/term', 'ShopController@getTermByYear');		
			Route::get('/shopinfo/detail/{id}', ['as' => 'shopinformation', 'uses' => 'ServiceController@shopinfoDetail']);	

			/*
			 *   user main page action
			 */
			Route::get('/mycar', ['as' => 'mycar', 'uses'=>'UserController@myCar']);
			Route::get('/schedule', ['as' => 'schedule', 'uses'=>'UserController@scheduleService']);
			Route::get('/rate', ['as' => 'rate.experience', 'uses'=>'UserController@rateExperience']);
			Route::get('/myprofile', ['as' => 'myprofile', 'uses'=>'UserController@myProfile']);

			/*
			 *    check userprofile whether selected car exists
			 */
			Route::post('/check/userprofile', ['as' => 'check.userprofile', 'uses' => 'UserController@checkUserProfile']);
			/*
			 *    routing add car page
			 */
			Route::get('/userprofile/addcar', ['as' =>'add.car.profile', 'uses' => 'UserController@addCarProfile']);
			/*
			 *   save profile for adding new car
			 */
			Route::post('/update/profile', ['as' => 'save.profile', 'uses' => 'UserController@updateProfile']);
			/*
			 *   user car detial page
			 */
			Route::get('/user/car/{id}', ['as' => 'user.car', 'uses' => 'UserController@showCarDetail']);
			Route::get('/delete/userprofile/{id}', 'UserController@deleteCar');
			/*
			 *   user profile update
			 */
			Route::post('/update/userprofile', 'UserController@updateUserProfile');

			/*
			 *   service booking.
			 */
			Route::get('/service/booking/{id}', 'ServiceController@bookService');

			Route::get('/calendar/event/remove/{id}', 'UserController@removeEvent');

			/*
			 *  user booking status show
			 */
			Route::post('/week/booking', ['as' => 'booking.status', 'uses' => 'UserController@scheduleBooking']);
			Route::get('/week/booking', ['as' => 'booking.get', 'uses' => 'UserController@getBooking']);

			Route::get('/service/detail/{id}/{id2}', 'UserController@serviceDetail');

			Route::post('/shop/service/rate', 'UserController@rateService');
			Route::get('/shop/service/detail/{id}', ['as' => 'service.detail', 'uses' => 'ServiceController@shopserviceDetail']);

			Route::post('/service/appoint', ['as'=>'service.appoint','uses'=>'ServiceController@postServiceAppoint']);

			Route::post('/service/appointment', ['as' => 'service.appointment', 'uses' => 'ServiceController@serviceAppointment']);

			Route::get('/booking/confirm', 'ServiceController@confirmAppointment');
	});

});

