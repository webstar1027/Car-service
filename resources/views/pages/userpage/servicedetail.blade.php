@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/servicedetail.css')}}">

@endsection

@section('scripts')

<script type="text/javascript" src="{{asset('js/servicedetail.js')}}"></script>

@endsection
@section('content')
  <div class="container">
     <div class="col-md-12 service-detail">
        <div class="row">
           <div class="form-group">
           	  <h4> Master Service Name : </h4>
     					<p> {{$master['master_service_name']}}
           </div>
        </div>
        <div class="row">
           <div class="form-group">
           	  <h4> Lowest Service Name : </h4>
     					<p> {{$service['category_name']}} </p>
           </div>
        </div>
        <div class="row">
           <div class="form-group">
           	  <h4> Price Type : </h4>
     					<p> {{$price_type['query_name']}} </p>
           </div>
        </div>
        <div class="row">
           <div class="form-group">
           	  <h4> Show Line Items : </h4>
     					<div class="table-responsive">
     						 <table class="table table-bordered">
     						 	 <thead>
     						 	 	<tr>
     						 	 		 <td> # </td>
     						 	 		 <td> Line Item Name </td>
     						 	 		 <td> Description</td>
     						 	 		 <td> Price </td>
     						 	 	</tr>
     						 	 </thead>
     						 	 <tbody>
     						 	 	 <?php $count =1 ;?>
     						 	 	 @foreach($prices as $price)
     						 	 	 <tr>
     						 	 	 	 <td> {{$count++}} </td>
     						 	 	 	 <td>{{$price['pricetype_name']}} </td>
     						 	 	 	 <td> {{$price['description']}} </td>
     						 	 	 	 <td> ${{$price['price']}} </td>
     						 	 	 </tr>
     						 	 	 @endforeach
     						 	 </tbody>
     						 </table>
     					</div>
           </div>
        </div>
         <div class="row">
           <div class="form-group">
           	  <h4> Prices : </h4>           	  	
     					<div class="table-responsive">
     						 <table class="table table-bordered">
     						 	 <thead>
     						 	 	 <tr>
     						 	 	 	 <td>Service ID</td>
     						 	 	 	 <td>Child Service Name</td>
     						 	 	 	 <td>Year</td>
     						 	 	 	 <td>Make</td>
     						 	 	 	 <td>Model</td>
     						 	 	 	 <td>Term</td>
     						 	 	 	 @for($i = 0; $i < $number; $i++)
     						 	 	 	  <td> Item {{$i+1}} Price</td>
     						 	 	 	 @endfor
     						 	 	 	 <td>Total Price</td>
                       <td>Status</td>
                       <td>Action</td>
     						 	 	 </tr>
     						 	 </thead>
     						 	 <tbody>
     						 	 	 <tr>
     						 	 	 	<td> {{$service['serviceofshop_id']}} </td>
     						 	 	 	<td> {{$service['category_name']}} </td>
     						 	 	 	<td> {{$service['year']}} </td>
     						 	 	 	<td> {{$service['make']}} </td>
     						 	 	 	<td> {{$service['model']}} </td>
     						 	 	 	<td> {{$service['term']}} </td>
     						 	 	 	 @for($i = 0; $i < $number; $i++)
     						 	 	 	  <td>${{$prices[$i]['price']}}</td>
     						 	 	 	 @endfor
     						 	 	 	 <td>${{$service['total_price']}} </td>
     						 	 	 	 @if($master['status'] == 0)
     						 	 	 	  <td> Active </td>
     						 	 	 	 @elseif($master['status'] == 1)
     						 	 	 	   <td> Exprire </td>
     						 	 	 	 @else
     						 	 	 	   <td> Deactive </td>
     						 	 	 	 @endif
     						 	 	 	  <td style="cursor: pointer" onclick="location.href='/calendar/event/remove/{{$event_id}}'">cancel</td>
     						 	 	 </tr>
     						 	 </tbody>
     						 </table>
     					</div>
           </div>
        </div>
        <div class="text-center">
        	 <button class="btn btn-primary" onclick="location.href='/schedule'"> Back </button>
        </div>
     </div>
 </div>
 @endsection
