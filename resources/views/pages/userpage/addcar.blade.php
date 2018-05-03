@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/addcar.css')}}">

@endsection

@section('scripts')

<script type="text/javascript" src="{{asset('js/addcar.js')}}"></script>

@endsection
@section('content')
  <div class="container">
    <div class="col-md-7 col-md-offset-2 car-selection">
     	<div class="row">		 		
			  <div class="col-md-12 part">
		        <h5><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>&nbsp  Car Selection</h5>
						<div class="col-md-7 col-md-offset-3 part-body">		   					  	   			  			
			   			<div id="car_select">
		   			 		<div class="form-group">
		   			 			 </br>
		   			 			 </br>
			   			 		  <label for="sel1">Year:</label>				   			 		 
							      <select class="form-control" id="year1">  
							         <option selected hidden>please select car year</option>	      
								       @for($i = 1980; $i <= 2020; $i++)
								       <option value="{{$i}}">{{$i}}</option>							       
								       @endfor
							      </select>				      
		   			 		</div>
		   			 		<div class="form-group" id="make1">				   			 		
		   			 		</div>
		   			 		<div class="form-group" id="model1">  			 						   			 	
		   			 		</div>
		   			 		<div class="form-group" id="term1">				   			 		
		   			 		</div>		   			 			 		
		   			  </div>
		   			</div>
				</div> 	
	    </div> 
	  </div>

    <div class="col-md-7 col-md-offset-2 current-mileage" style="margin-top: 20px;">
	    <div class="row">
	    	<div class="col-md-12">
		    	<h5><i class="fa fa-car" aria-hidden="true"></i>&nbsp Current Mileage</h5>
		    	<input type="text" id="mileage" class="form-control" value="" />
		    </div>
	    </div>
	    <div class="row">
	    	<div class="col-md-12">
		    	<h5><i class="fa fa-tasks" aria-hidden="true"></i>&nbsp Car Description Name </h5>
		    	<input type="text" id="description_name" class="form-control" value="" />
		    </div>
	    </div>
	  </div>

	  <div class="col-md-7 col-md-offset-2 annual-miles" style="margin-top: 20px;">
	    <div class="row">
	    	<div class="col-md-12">
		    		<h5><i class="fa fa-universal-access" aria-hidden="true"></i>&nbsp  Annual Miles Driven</h5>
			    	<select class="form-control" id="annual_miles">
			    		 <option selected hidden></option>
			    		 @for($i=5000; $i<=60000; $i=$i+5000)
			    		 <option value="{{$i}}">{{$i}} miles</option>
			    		 @endfor
			    	</select>
		    </div>
	    </div>
	  </div>

	  <div class="col-md-7 col-md-offset-2 notifications" style="margin-top: 20px;">
	    <div class="row">
	    	<div class="col-md-12">
		    		<h5><i class="fa fa-shield" aria-hidden="true"></i>&nbsp  Notifications</h5>
			    	<select class="form-control" id="annual_miles">
			    		 <option selected hidden></option>
			    		 <option value="enable"> Enable Notifications </option>
			    		 <option value="diable"> Disable Notifications </option>
			    	</select>
		    </div>
	    </div>
	  </div>	  

	   <div class="col-md-7 col-md-offset-2 notification-type" style="margin-top: 20px; margin-bottom: 40px; display: none;">
	    <div class="row">
	    	<div class="col-md-12">
		    		<h5><i class="fa fa-bell" aria-hidden="true"></i>&nbsp  Notifications Types</h5>
		    		<div class="form-group">
			    		<label>Engine Oil Change Notification</label>
				    	<select class="form-control" id="oil_change">
				    		 <option selected hidden></option>
				    		 <option value="0">Disable</option>
				    		 <option value="1"> Every 1 month </option>
				    		 @for($i=2;$i<=11; $i++)
				    		 <option value="{{$i}}">Every {{$i}} Months</option>
				    		 @endfor
				    		 <option value="12"> Up to 12 months </option>
				    	</select>
				    </div>

			    	<div class="form-group">
			    		 <label>Transmission Oil change Notification</label>
					     <select class="form-control" id="transmission">
					    		 <option selected hidden></option>
					    		 <option value="0">Disable</option>
					    		 <option value="1"> Every 1 month </option>
					    		 @for($i=2;$i<=11; $i++)
					    		 <option value="{{$i}}">Every {{$i}} Months</option>
					    		 @endfor
					    		 <option value="12"> Up to 12 months </option>
					    	</select>
			    	</div>

			    	<div class="form-group">
			    		<label>General Inspection Notification</label>
			    		<select class="form-control" id="general_inspection">
			    		 	<option selected hidden></option>
			    		 	<option value="0">Disable</option>
			    		 	<option value="1"> Every 1 month </option>
			    		 	@for($i=2;$i<=11; $i++)
			    		 	<option value="{{$i}}">Every {{$i}} Months</option>
			    		 	@endfor
			    		 	<option value="12"> Up to 12 months </option>
			    		</select>
			    	</div>

			    	<div class="form-group">
				    	<label>Brake Check Notification</label>
				    	<select class="form-control" id="brake_check">
				    		 <option selected hidden></option>
				    		 <option value="0">Disable</option>
				    		 <option value="1"> Every 1 month </option>
				    		 @for($i=2;$i<=11; $i++)
				    		 <option value="{{$i}}">Every {{$i}} Months</option>
				    		 @endfor
				    		 <option value="12"> Up to 12 months </option>
				    	</select>
				    </div>

				    <div class="form-group">
				    	<label>Tire Check Notification</label>
				    	<select class="form-control" id="tire_check">
				    		 <option selected hidden></option>
				    		 <option value="0">Disable</option>
				    		 <option value="1"> Every 1 month </option>
				    		 @for($i=2;$i<=11; $i++)
				    		 <option value="{{$i}}">Every {{$i}} Months</option>
				    		 @endfor
				    		 <option value="12"> Up to 12 months </option>
				    	</select>
				    </div>
		    </div>
	    </div>
	  </div>	  
    
    <div class="col-md-7 col-md-offset-2" style="margin-top:40px;margin-bottom: 30px;">
    	<div class="text-center">
	    	<button class="btn btn-primary" id='save'><i class="fa fa-save"></i>&nbsp Save </button>
	    </div>
    </div>
 </div>
 @endsection
