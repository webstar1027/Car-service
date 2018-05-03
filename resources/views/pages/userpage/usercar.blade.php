@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/usercar.css')}}">
@endsection
@section('content')
  <div class="container">
    <div class="col-md-8 col-md-offset-2 user-profile">
      <form role="form" id="usercar_form" class="form-horizontal">
    	<input type="hidden" id="userofcar_id" value="{{$userprofile['userofcar_id']}}"/>
    	<div class="row">
    		<h5>  Car Name </h5>
        <div class="form-group">
    		  <label><input type="text" class="form-control" value="{{$userprofile['description_name']}}" name="description_name" id="description_name"/></label>
        </div>
    	</div>
    	<div class="row">
    		<h5>  Car Info </h5>
        <div class="form-group">
    		  <label>{{$userprofile['year']}}&nbsp{{$userprofile['make']}}&nbsp{{$userprofile['model']}}&nbsp{{$userprofile['term']}}</label>
        </div>
    	</div>
    	<div class="row">
    		<h5> Current Mileage </h5>
        <div class="form-group">
    		  <label><input type="text" class="form-control" id="current_mileage" name="current_mileage" value="{{$userprofile['current_mileage']}}"></label>
        </div>
    	</div>
    	<div class="row">
    		<h5> Annual Miles </h5>
        <div class="form-group">
    		  <label><input type="text" class="form-control" id="annual_miles" name="annual_miles" value="{{$userprofile['annual_miles']}}"></label>
        </div>
    	</div>
        @foreach($notifications as $notification)
          <?php
          	switch($notification['notification_type_name']){
          		case 'oil change':
          		  $oil_change_notification = $notification['status'];
          		  break;
          		case 'transmission':
          		  $transmission_notification = $notification['status'];
          		  break;
          		case 'general inspection':
          		  $general_inspection_notification = $notification['status'];
          		  break;
          		case 'brake check':
          		  $brake_check_notification = $notification['status'];
          		  break;
          		case 'tire check':
          		  $tire_check_notification = $notification['status'];
          		  break;	

          	}

          ?>
        @endforeach         
    	@if($userprofile['notification_status'] == 1)


    	<div class="row">
    		<h5> Notifications </h5>
    		<div class="row">
    			<h5> Engine Oil Change Notification</h5>
    			<select class="form-control" id="oil_change">
    				<?php
    				if(!isset($oil_change_notification )) {
    					?>
    				 <option selected hidden value="0">disable</option>
    				 <?php
    				}else{?>
	    				@if($oil_change_notification == 1)
	    				<option selected  hidden value="1">Every 1 month </option>
	    				@elseif($oil_change_notification == 12)
	    				<option selected hidden  value="12">Every to 12 months </option>
	    				@else
	    				<option selected hidden value="{{$oil_change_notification}}">Every {{$oil_change_notification}} months </option>
	    				@endif
	    				
    				<?php
	    			}	    			
	    			?>
	    			 <option value="0">Disable</option>
		    		 <option value="1"> Every 1 month </option>
		    		 @for($i=2;$i<=11; $i++)
		    		 <option value="{{$i}}">Every {{$i}} Months</option>
		    		 @endfor
		    		 <option value="12"> Every 12 months </option>
    			</select>
    		</div>

    		<div class="row">
    			<h5> Transmission Oil Change Notification</h5>
    			<select class="form-control" id="transmission">
    				<?php
    				if(!isset($transmission_notification)) {
    					?>
    				 <option selected hidden value="0">disable</option>
    				 <?php
    				}else{?>
	    				@if($transmission_notification == 1)
	    				<option selected hidden  value="1">Every 1 month </option>
	    				@elseif($transmission_notification == 12)
	    				<option selected hidden  value="12">Every 12 months </option>
	    				@else
	    				<option selected hidden  value="{{$transmission_notification}}">Every {{$transmission_notification}} months </option>
	    				@endif
	    				
	    			<?php
	    			}
	    			?>
	    			 <option value="0">Disable</option>
		    		 <option value="1"> Every 1 month </option>
		    		 @for($i=2;$i<=11; $i++)
		    		 <option value="{{$i}}">Every {{$i}} Months</option>
		    		 @endfor
		    		 <option value="12"> Every 12 months </option>
    			</select>
    		</div>

    		<div class="row">
    			<h5> General Inspection Notification</h5>
    			<select class="form-control" id="general_inspection">
    				<?php
    				if(!isset($general_inspection_notification)) {
    					?>
    				 <option selected hidden value="0">disable</option>
    				 <?php
    				}else{?>
	    				@if($general_inspection_notification == 1)
	    				<option selected hidden  value="1">Every 1 month </option>
	    				@elseif($general_inspection_notification == 12)
	    				<option selected hidden  value="12">Every 12 months </option>
	    				@else
	    				<option selected hidden  value="{{$general_inspection_notification}}">Every {{$general_inspection_notification}} months </option>
	    				@endif
	    				
	    			<?php
	    			}
	    			?>
	    			 <option value="0">Disable</option>
		    		 <option value="1"> Every 1 month </option>
		    		 @for($i=2;$i<=11; $i++)
		    		 <option value="{{$i}}">Every {{$i}} Months</option>
		    		 @endfor
		    		 <option value="12"> Every 12 months </option>
    			</select>
    		</div>

    		<div class="row">
    			<h5> Brake Check Notification</h5>
    			<select class="form-control" id="brake_check">
    				<?php
    				if(!isset($brake_check_notification)) {
    					?>
    				 <option selected hidden value="0">disable</option>
    				 <?php
    				}else{?>
	    				@if($brake_check_notification == 1)
	    				<option selected hidden  value="1">Every 1 month </option>
	    				@elseif($brake_check_notification == 12)
	    				<option selected hidden  value="12">Every 12 months </option>
	    				@else
	    				<option selected hidden  value="{{$brake_check_notification}}">Every {{$brake_check_notification}} months </option>
	    				@endif	    				
    				<?php
	    			}
	    			?>
	    			 <option value="0">Disable</option>
		    		 <option value="1"> Every 1 month </option>
		    		 @for($i=2;$i<=11; $i++)
		    		 <option value="{{$i}}">Every {{$i}} Months</option>
		    		 @endfor
		    		 <option value="12"> Every 12 months </option>
    			</select>
    		</div>

    		<div class="row">
    			<h5> Tire Check Notification</h5>
    			<select class="form-control" id="tire_check">
    				<?php
    				if(!isset($tire_check_notification)) {
    					?>
    				 <option selected hidden value="0">disable</option>
    				 <?php
    				}else{?>
	    				@if($tire_check_notification == 1)
	    				<option selected hidden  value="1">Every 1 month </option>
	    				@elseif($tire_check_notification == 12)
	    				<option selected hidden  value="12">Every 12 months </option>
	    				@else
	    				<option selected hidden  value="{{$tire_check_notification}}">Every {{$tire_check_notification}} months </option>
	    				@endif
	    				
	    			<?php
	    			}
	    			?>
	    			 <option value="0">Disable</option>
		    		 <option value="1"> Every 1 month </option>
		    		 @for($i=2;$i<=11; $i++)
		    		 <option value="{{$i}}">Every {{$i}} Months</option>
		    		 @endfor
		    		 <option value="12"> Every 12 months </option>
    			</select>
    		</div>   		

    	</div>
        @else
        <div class="row">
    		<h5> Notifications </h5>
    		<div class="row">
    			<h5> Engine Oil Change Notification</h5>
    			<select class="form-control" id="oil_change">
    				 <option value="0">Disable</option>
		    		 <option value="1"> Every 1 month </option>
		    		 @for($i=2;$i<=11; $i++)
		    		 <option value="{{$i}}">Every {{$i}} Months</option>
		    		 @endfor
		    		 <option value="12"> Every 12 months </option>
    			</select>
    		</div>

    		<div class="row">
    			<h5> Transmission Oil Change Notification</h5>
    			<select class="form-control" id="transmission">
    				 <option value="0">Disable</option>
		    		 <option value="1"> Every 1 month </option>
		    		 @for($i=2;$i<=11; $i++)
		    		 <option value="{{$i}}">Every {{$i}} Months</option>
		    		 @endfor
		    		 <option value="12"> Every 12 months </option>
    			</select>
    		</div>

    		<div class="row">
    			<h5> General Inspection Notification</h5>
    			<select class="form-control" id="general_inspection">
    				 <option value="0">Disable</option>
		    		 <option value="1"> Every 1 month </option>
		    		 @for($i=2;$i<=11; $i++)
		    		 <option value="{{$i}}">Every {{$i}} Months</option>
		    		 @endfor
		    		 <option value="12"> Every 12 months </option>
    			</select>
    		</div>

    		<div class="row">
    			<h5> Brake Check Notification</h5>
    			<select class="form-control" id="break_check">
    				 <option value="0">Disable</option>
		    		 <option value="1"> Every 1 month </option>
		    		 @for($i=2;$i<=11; $i++)
		    		 <option value="{{$i}}">Every {{$i}} Months</option>
		    		 @endfor
		    		 <option value="12"> Every 12 months </option>
    			</select>
    		</div>

    		<div class="row">
    			<h5> Tire Check Notification</h5>
    			<select class="form-control" id="tire_check">
    				 <option value="0">Disable</option>
		    		 <option value="1"> Every 1 month </option>
		    		 @for($i=2;$i<=11; $i++)
		    		 <option value="{{$i}}">Every {{$i}} Months</option>
		    		 @endfor
		    		 <option value="12"> Every 12 months </option>
    			</select>
    		</div>   		

    	</div>
    	@endif
    	<div class="row">
			<input id="{{$userprofile['userofcar_id']}}" type="checkbox" value="{{$userprofile['userofcar_id']}}" class="remove-usercar" />
            <label for="{{$userprofile['userofcar_id']}}">   Remove this car from user profile </label>       
    	</div>

    	<div class="row">
    		<div class="text-center">
    			<button class="btn btn-primary" onclick="location.href='/mycar'"> <i class="fa fa-undo" aria-hidden="true"></i> Back </button>
    			<button class="btn btn-primary" id="change"><i class="fa fa-save"></i> Change Save </button>
    		</div>
    	</div>
    </div>
     <div class='modal fade' id='myModal' role='dialog' data-keyboard='false' data-backdrop='static'>
      <div class='modal-dialog' role='document'>                             
          <div class='modal-content'>     
              <div class='modal-header'>
               <i class='fa fa-close' data-dismiss='modal' style='float:right;cursor:pointer;'></i>
               <h4 class="modal-title">Confirm remove car from user profile</h4>
              </div>       
              <div class='modal-body'>            
                 Would you remove this car from user profile?
              </div>    
              <div class="modal-footer">
                  <button type="button" class="btn btn-default number_save" data-dismiss="modal">Confirm</button>
                  <button type="button" class="btn btn-default cancel" data-dismiss="modal">Cancel</button>
              </div>                             
          </div>
      </div>
    </form>
  </div>
</div>
@endsection
@section('scripts')
<script src="{!! URL::asset('lib/bootstrap/dist/js/bootstrap.min.js') !!}"></script>
<script src="{!! URL::asset('lib/bootstrapvalidator/dist/js/bootstrapValidator.min.js') !!}"></script>
<script type="text/javascript" src="{{asset('js/usercar.js')}}"></script>
@endsection