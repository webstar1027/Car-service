@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/shopowner.css')}}">
@endsection
@section('scripts')
<script type="text/javascript" src="{{asset('js/shopowner.js')}}"></script>
@endsection
@section('content')
  <div class="container">
     <div class="col-md-12">
				<div class="panel panel-primary">
	   			<div class="panel-heading">   				
	   				  <h4> <i class="fa fa-edit"></i> My Services</h4>   				
	   			</div>	   
	   			@if($upload_status == true)
					  <?php $file_upload_status = 'You should upload Business License and Business Insurance. Please go to My Profile Page to more details';?>
					@endif
					@if($insurance_status != true)
					  <?php $insurance = 'Your Business Insurance is not verified. Please go to My Profile Page to more details';?>
					@endif
					@if($license_status != true)
					  <?php $license = 'Your Business License is not verified. Please go to My Profile Page to more details';?>
					@endif
					@if($payment_status != true)
					  <?php $payment = 'Your payment is not verified, Please go to My Subscription page to add Subscription';?>
					@endif
					@if($payment_status == 'noregister')
					  <?php $payment = 'You should select one Maintfy Subscription Plan, Please go to My Subscription page to add Subscription';?>
					@endif
					@if($number_valid !== true)
					  <?php $number = 'Your BAR number, EPA number is not valid. Please check your BAR number and EPA number';?>
					@endif		
   		   	@if($insurance_status == true && $license_status == true && $payment_status == true && $number_valid == true)
	   		   	<div class="panel-body"> 
   			      <a class="btn btn-success" href="{{route('get.category')}}"> Add New Service <i class="fa fa-plus"></i></a>    
	   				  <div class="serviceofcar" style="margin-top:30px;">
	   				  	<div class="table-responsive">
			   			    <table class="table table-inverse table-bordered"  id="service_body"> 
								     <thead>
								      <tr>
								        <td>No</td>              
								        <td>Master Service Name</td>
								        <td>Created Date</td>
								        <td>Active Status Number</td>
								        <td>Expire status Number</td>
								        <td>Deactive Status Number</td>
								        <td>Action</td>										     
								      </tr>
								     </thead>
								     <tbody>              
								       <?php $count = 1;?>
								       @foreach($master_service_data as $item)
								        <tr id="{{$item['id']}}">
								        	<td>{{$count++}}</td>
								        	<td id="name{{$item['id']}}" style="cursor:pointer">{{$item['masterservice_name']}}</td>
								        	<td id="date{{$item['id']}}">{{$item['created_date']}}</td>
								        	<td id="active{{$item['id']}}">{{$item['active_number']}}</td>
								        	<td id="expire{{$item['id']}}">{{$item['expire_number']}}</td>
								        	<td id="deactive{{$item['id']}}">{{$item['deactive_number']}}</td>
								        	<td><a href="{{route('master.detail', ['id' => $item['id']])}}"><i class="fa fa-edit">edit</i></a></td>									        		  
								        </tr>
								       @endforeach
								    </tbody>
								 </table>
								</div>
		   				</div>	   		
					</div>
					@else
					<div class="panel-body">
	   		   	 <ul>
	   		   	 	 @if(isset($file_upload_status))
	   		   	 	  <li><p>{{$file_upload_status}}</p></li>
	   		   	 	 @endif
	   		   	 	 @if(isset($insurance))
	   		   	 	  <li><p>{{$insurance}}</p></li>
	   		   	 	 @endif
	   		   	 	 @if(isset($license))
	   		   	 	  <li><p>{{$license}}</p></li>
	   		   	 	 @endif
	   		   	 	 @if(isset($payment))
	   		   	 	  <li><p>{{$payment}}</p></li>
	   		   	 	 @endif
	   		   	 	 @if(isset($number))
	   		   	 	  <li><p>{{$number}}</p></li>
	   		   	 	 @endif	   		   	
	   		   	 </ul>
	   		   </div>	
					@endif       
		   </div>
	   </div> 
   </div>
   @yield('content')	
   <div class="loader" style="display:none;">
   </div>
   	<div class="remodal" data-remodal-id="modal" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
		  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
		  <div>
		    <h2 id="modal1Title">Warning</h2>
		    <p id="modal1Desc">
		      Inputed car information does not exists on database.
		      Please confirm car information again!.
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
		       That service is registered already!.
		    </p>
		  </div>
		  <br>
		  <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
		  <button data-remodal-action="confirm" class="remodal-confirm">OK</button>
		</div>

		<div class="remodal" data-remodal-id="modal3" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
		  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
		  <div>
		    <h2 id="modal1Title">Warning</h2>
		    <p id="modal1Desc">
		       All information must be inputed exactly.
		       Please check input information again!.
		    </p>
		  </div>
		  <br>
		  <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
		  <button data-remodal-action="confirm" class="remodal-confirm">OK</button>
		</div>
   

@endsection
