@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/shophour.css')}}">
@endsection
@section('content')
<div class="container"> 	 
 	 <div class="col-md-7 col-md-offset-2 part">
			<form role="form" id="shophour_form" action="{{url('/shop/hour/update')}}" method="POST" class="form-horizontal">				
	    		<legend>Shop Hour:</legend>
	        <?php 
	        if(count($shophours) != 0) {
	        ?>
	        	<?php $count=0;$time_count1 = 1;?>
	    			@foreach($shophours as $hour)  
	    			<div class="row">
	    					<?php switch($hour['dayofweek']){
		                case '0':
		                	$date = "Monday";
		                	break;
		                case '1':
		                	$date = "Tuesday";
		                	break;
		                case '2':
		                	$date = "Wednesday";
		                	break;
		                case '3':
		                	$date = "Thursday";
		                	break;
		                case '4':
		                	$date = "Friday";
		                	break;
		                case '5':
		                	$date = "Saturday";
		                	break;
		                 case '6':
		                	$date = "Sunday";
		                	break;
		          	} 
		          	
		          	?>     

		          <span class="col-sm-2" style="padding-top: 8px;"> {{$date}} </span>      
		    			<div class="col-sm-3">
		    				<div class="form-group">
	    					  <div class="input-group date" id="datetimepicker{{$time_count1}}"> 	          
			          	 <input type='text' name="open_time{{$count}}" class="form-control" value="<?php if(isset($hour['close_time'])) echo date('h:i A', strtotime($hour['open_time'])); else ''?>" />
			             <span class="input-group-addon">
			                <span class="glyphicon glyphicon-time"></span>
			             </span>
				            </div>
		    				</div>
		    			</div>
		    			<span class="col-sm-1" style="padding-top: 8px;"> To </span>
		    			<div class="col-sm-3">
		    				<div class="form-group">
		    					  <div class="input-group date" id="datetimepicker<?php echo $time_count1+7; ?>"> 	          
					          	 <input type='text' name="close_time{{$count}}" class="form-control" value="<?php if(isset($hour['close_time'])) echo date('h:i A', strtotime($hour['close_time'])); else '';?>" />
					             <span class="input-group-addon">
					                <span class="glyphicon glyphicon-time"></span>
					             </span>
				            </div>
		    				</div>
		    			</div>
		    			<div class="col-sm-3" style="text-align: center;">
              	<div class="form-group">
            		 <label class="control-label"> Close &nbsp;
	    					 <input id="{{$time_count1}}" type="checkbox" value="" />
                 <label for="{{$time_count1}}"></label></label>      
		    				</div>
		    			</div>
	         </div>
	         <?php $time_count1++;$count++;?>
	        @endforeach
	        <?php
	        }
	        else{
	        	$time_count = 0;
	        	for($i = 1; $i <= 7; $i++) {
	        	
	        		?>
	        		<div class="row">
	    					<?php switch($i){
	                case '1':
	                	$date = "Monday";
	                	break;
	                case '2':
	                	$date = "Tuesday";
	                	break;
	                case '3':
	                	$date = "Wednesday";
	                	break;
	                case '4':
	                	$date = "Thursday";
	                	break;
	                case '5':
	                	$date = "Friday";
	                	break;
	                case '6':
	                	$date = "Saturday";
	                	break;
	                 case '7':
	                	$date = "Sunday";
	                	break;
		          	} 
		          	
		          	?>     

		          <span class="col-sm-2" style="padding-top: 8px;"> {{$date}} </span>      
		    			<div class="col-sm-3">
		    				<div class="form-group">
	    					  <div class="input-group date" id="datetimepicker{{$i}}"> 	          
			          	 <input type='text' name="open_time{{$time_count}}" class="form-control" value="" />
			             <span class="input-group-addon">
			                <span class="glyphicon glyphicon-time"></span>
			             </span>
			            </div>
		    				</div>
		    			</div>
		    			<span class="col-sm-1" style="padding-top: 8px;"> To </span>
		    			<div class="col-sm-3">
		    				<div class="form-group">
		    					  <div class="input-group date" id="datetimepicker<?php echo $i+7; ?>"> 	          
					          	 <input type='text' name="close_time{{$time_count}}" class="form-control" value="" />
					             <span class="input-group-addon">
					                <span class="glyphicon glyphicon-time"></span>
					             </span>
				            </div>
		    				</div>
		    			
		    			</div>
		    			<div class="col-sm-3" style="text-align: center;">
              	<div class="form-group">
              		 <label class="control-label"> Close &nbsp;
		    					 <input id="{{$i}}" type="checkbox" value="" />
                   <label for="{{$i}}"></label></label>      
		    				</div>
		    			</div>
		    		
	         </div>
	         <?php 
	         $time_count++;
	        	}
	        }
	        ?>
	     	    	
				<div class="text-center">
				  <input type="submit" class="btn btn-primary">
				</div>
				<div class="form-group">
	    		<input type="hidden" name="id" value="{{$id}}">
	    	</div>	    	
			</form>
	</div>
</div>
@endsection

@section('scripts')
<script src="{!! URL::asset('lib/bootstrap-datetimepicker/js/moment.js') !!}"></script>
<script src="{!! URL::asset('lib/bootstrapvalidator/dist/js/bootstrapValidator.min.js') !!}"></script>
<script src="{!! URL::asset('lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') !!}"></script>
<script type="text/javascript" src="{{asset('js/shophour.js')}}"></script>

@endsection