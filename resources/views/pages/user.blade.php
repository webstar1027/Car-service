@extends('layouts.app')
@section('css')

<link rel="stylesheet" type="text/css" href="{{asset('css/user.css')}}">

@endsection

@section('content')
  <div class="container">
    <div class="col-md-12">   			
			<form role="form" id="service_search_form" class="form-horizontal">
				<div class="panel panel-primary">
	 			<div class="panel-heading">   				
	 				  <h4> <i class="fa fa-search"></i> Service Search</h4>   				
	 			</div>
	 			<div class="panel-body">	   			 		
	   			<div class="row">
	   				<!-- user car selection part -->
	   				<div class="col-md-12 part">
	   				  <h4><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>  Car Selection</h4>
		   				<div class="col-md-7 col-md-offset-3 part-body">		   					  	   			  			
						   	<div class="form-group" id="car_select">				   			 	
					   			<select class="form-control" name="car_selection" id="car_selection">
				   			    <option  value=""></option>
			   			 			<option value="addcar"> Add new car to profile </option>
			   			 			 <?php $count = 1;?>
			   			 			 @foreach($usercars as $car)
			   			 			  <option value="{{$car['car_id']}}"> {{$car['description_name']}} &nbsp; {{$car['year']}} {{$car['make']}} {{$car['model']}} {{$car['term']}}
			   			 			  </option>
			   			 			 @endforeach
				   			 	</select>		 		
	   			 		    @foreach($usercars as $car)
	   			 			   <input type="hidden" id="{{$car['car_id']}}" value="{{$car['current_mileage']}}"/>
	   			 			  @endforeach
					   			 		
					   		</div>
					   	</div>
	   				</div> 	
	   				<!-- category selection part -->
	   				<div class="col-md-12 part">	   						
			   			<h4><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>  Category Selection</h4>
	   					<div class="col-md-7 col-md-offset-3 part-body">			   			  			
				   			<div class="category-select-part">		   						   			  			
					   			<div id="category_select">					   			
					   			 		
					   				<div class="form-group">			
					   				  <label for="sel1">Category:</label>						   				 		 					   			 		 
							        <select class="form-control" name="category_name" id="category_name">
							           <option value=""></option>				       
									       @foreach($categorys as $category)
									        <option value="{{$category}}">{{$category}}</option>							       
									       @endforeach
							        </select>
				   			 		</div>	
				   			 		<div class="form-group" id = "sub-category">					   			 					 			
				   			 		</div>
				   			 		<div class="form-group" id = "sub2-category">
				   			 		</div>
				   			 		<div class="form-group" id = "sub3-category">
				   			 		</div>
				   			 		<div class="form-group" id = "sub4-category">
				   			 		</div>		
				   			 	</div>		  
	   					  </div>	
	   					</div>  
	   				</div>	   				
	   			</div>  

	   			<!-- user info input part -->
	   			<div class="row">
	   				<div class="col-md-12 part">
	   				  <div class="form-group">
		   					<label>Current Car Mileage</label>
		   					<input class="form-control" id="current_mileage" value="" name="currentmileage" />
		   					@if ($errors->has('current_mileage'))
									<div class="error">{{ $errors->first('current_mileage') }}</div>
								@endif
		   			  </div>
		   				<div class="form-group">
		   					<label>Current Your Zipcode</label>
		   					<input class="form-control" id="zipcode" name="zipcode" value=""/>
		   					@if ($errors->has('zip_code'))
									<div class="error">{{ $errors->first('zip_code') }}</div>
								@endif
		   				</div>
		   				<div class="form-group" id="mile_select">
		   					<label>Distance</label>
		   					 	<select class="form-control">
		   					 	 	<option selected hidden></option>
		   					 	 	@for($i=10; $i < 100; $i+=10)
		   					 	 	 <option value="{{$i}}">Within {{$i}} miles </option>
		   					 	 	@endfor
		   					 	 	@for($i=100; $i<=500; $i+=50)
		   					 	 	  <option value="{{$i}}">Within {{$i}} miles </option>
		   					 	 	@endfor
		   					 	 	<option value="all">Within all miles</option>
		   					 	</select>
		   				</div>
	   				</div>
	   		</div>			    
		  </div>

		</form>
    </div>
  
    <div class="form-group">
   	  <a class="col-md-2 col-md-offset-5 btn btn-primary service-search">Search <i class="fa fa-search" aria-hidden="true"></i></a>
    </div>
   	<div class="loader" style="display:none;">
   	</div>
   	
   	<div class="remodal" data-remodal-id="modal" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
		  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
		  <div>
		    <h2 id="modal1Title">Search error</h2>
		    <p id="modal1Desc">
		      Inputed Service is not registered.
		      Shop owner must register this type of service of car information.
		    </p>
		  </div>
		  <br>
		  <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
		  <button data-remodal-action="confirm" class="remodal-confirm">OK</button>
		</div>

		<div class="remodal" data-remodal-id="modal1" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
		  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
		  <div>
		    <h2 id="modal1Title">Warning</h2>
		    <p id="modal1Desc">
		       There is no shop which has that service!.
		    </p>
		  </div>
		  <br>
		  <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
		  <button data-remodal-action="confirm" class="remodal-confirm">OK</button>
		</div>
		<div class="remodal" data-remodal-id="modal1" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
		  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
		  <div>
		    <h2 id="modal1Title">Warning</h2>
		    <p id="modal1Desc">
		       There is no shop within that miles.
		    </p>
		  </div>
		  <br>
		  <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
		  <button data-remodal-action="confirm" class="remodal-confirm">OK</button>
		</div>
    
    </form>
</div>
@endsection
@section('scripts')
<script src="{!! URL::asset('lib/bootstrap/dist/js/bootstrap.min.js') !!}"></script>
<script src="{!! URL::asset('lib/bootstrapvalidator/dist/js/bootstrapValidator.min.js') !!}"></script>
<script type="text/javascript" src="{{asset('js/user.js')}}"></script>
@endsection