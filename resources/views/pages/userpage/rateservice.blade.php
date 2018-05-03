@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/rateservice.css')}}">
@endsection
@section('scripts')
<script type="text/javascript" src="{{asset('js/rateservice.js')}}"></script>
@endsection
@section('content')
  <div class="container">	
    <div class="rate-assist">
    	<div class="row">
        <h4> My Service Rating &nbsp; <i class="fa fa-thumbs-up" aria-hidden="true" style="font-size: 18px;"></i></h4>   
      </div>

      <div class="row" style="margin-top: 20px;">    
	      <div class="table-responsive">  
	        <input type="hidden" value="{{$rate}}" id="rate_status" />             
	        <table class="table table-striped table-inverse table-bordered">
	         <thead class="thead-inverse">
	           <tr>
	             <td> Service ID</td>
	             <td> Lowest Service Name </td>
	             <td> Time  </td>
	             <td> Duration </td>
	             <td> Shop Name </td>
	             <td> User Car Description </td>
	             <td> Car Info </td>
	             <td> My Rating </td>
	           </tr>
	         </thead>
	         <tbody>
	         	 <?php $count = 1;?>
	           @foreach($event_data as $item)
	           <input type="hidden" class="{{$count}}" value="{{$item['service_id']}}"/> 
	           <tr id="{{$count}}">
	             <td>{{$item['service_id']}}</td>
	             <td>{{$item['event_name']}}</td>
	             <td>{{$item['start_time']}}</td>
	             <td>{{$item['duration']}} min</td>
	             <td>{{$item['shop_name']}}</td>
	             <td>{{$item['description_name']}}</td>
	             <td>{{$item['year']}} &nbsp; {{$item['make']}} &nbsp; {{$item['model']}} &nbsp;{{$item['term']}}</td>
	              <?php
	               if( isset($item['rating']) &&  $item['rating'] != 0 && ($item['start_time'] == $item['service_date'])) {
	              	?>
	              	 <td  id="mark{{$count}}"  class="rate" style="cursor: pointer;">		              	             	 
	             	    @include('partial.rating')
	                 </td>
	              <?php
	              }else{
	              	?>
	              	 <td  id="mark{{$count}}"  class="rate" style="cursor: pointer;">
	             	   service rate
	                 </td>
	               <?php	
	              }
	              ?>
	           </tr>
	           <?php $count++;?>
	           @endforeach
	         </tbody>
	       </table>      
	    </div>
	   </div>
  </div>
   <div class='modal fade' id='myModal' role='dialog' data-keyboard='false' data-backdrop='static'>
	  <div class='modal-dialog' role='document'>						     
      <div class='modal-content'>	  
        <div class='modal-header'>
	       <i class='fa fa-close' data-dismiss='modal' style='float:right;cursor:pointer;'></i>
	       <h4 class="modal-title">Please mark about your service (You can only give one rating)</h4>
	      </div>       
			  <div class='modal-body'>	

			    <fieldset class="rating">
				    <input type="radio" id="star5" name="rating" value="5" /><label id="5" class = "full" for="star5" ></label>    
				    <input type="radio" id="star4" name="rating" value="4" /><label id="4" class = "full" for="star4"></label>
				    <input type="radio" id="star3" name="rating" value="3" /><label id="3" class = "full" for="star3"></label>   
				    <input type="radio" id="star2" name="rating" value="2" /><label id="2" class = "full" for="star2"></label>
				    <input type="radio" id="star1" name="rating" value="1" /><label id="1" class = "full" for="star1"></label>   
				  </fieldset>
			  </div>	
			  <div class="modal-footer">
	        <button type="button" class="btn btn-default number_save" data-dismiss="modal">Save</button>
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		    </div>							 
  	  </div>
	  </div>
	</div>
 </div>
 @endsection
