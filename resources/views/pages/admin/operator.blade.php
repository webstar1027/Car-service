@extends('layouts.app')

@section('content')
 <style>
 	 .wrapper{
 	 	width:75%;
 	 	margin: 0 auto;
 	 	background-color: #eee;
 	 	margin-top:30px;
 	 }
 </style>
 <div class="wrapper">
 	<div class="panel panel-primary">
 		<div class="panel-heading">
 			 <p> Shop Status </p>
 		</div>
 		<div class="paenl-body" style="margin-top:30px;padding:50px;"> 	 	
     	
   			<table class="table table-hover table-bordered operator-table">
  	 	  <thead>			 	 
  	 	  	<th> Shop ID </th>
  	 	  	<th> Shop Name </th>
          <th> Shop BAR number </th>
          <th> Shop EPA number </th>
  	 	  	<th> Business License</th>
  	 	  	<th> Insurance Proof</th>
  	 	  	<th> Plan Selected</th>
  	 	  	<th> Plan Status</th>
  	 	  	<th> Shop Hours </th>
  	 	  	<th> Save </th>
  	 	  	<th> Edit </th>			 	  
  	 	  </thead>
  	 	  <tbody>
  	 	  	@foreach($shop_data as $item)
  	 	  	<tr id="{{$item['shopid']}}">
  	 	  		<td> {{$item['shopid']}} </td>
  	 	  		<td> {{$item['shopname']}}</td>
            <td> @if($item['BAR_status'] == 0) Not Valid @else Valid @endif </td>
            <td> @if($item['EPA_status']  == 0) Not Valid @else Valid @endif  </td>
  	 	  		<td id="license{{$item['shopid']}}"> 
    		 	  <?php
    		 	   if(isset($item['license'])){
    		 	   ?>
    		 	      @if($item['license'] == 0)
    		 	        <p>Processing </p>
    		 	      @elseif($item['license'] == 1)
    		 	        <p>Valid</p>
    		 	      @else
    		 	        <p>Need recertification</p>
    		 	      @endif
    		 	   <?php
    		 	   }
    		 	   else{
    		 	   	?>
    		 	   	<p> Not Uploaded</p>
    		 	   <?php
    		 	   }
    		 	   ?>
  	 	  		</td>
  	 	  		<td id="insurance{{$item['shopid']}}">
    		    <?php
    		 	   if(isset($item['insurance'])){
    		 	   ?>
    		 	      @if($item['insurance'] == 0)
    		 	        <p>Processing </p>
    		 	      @elseif($item['insurance'] == 1)
    		 	        <p>Valid</p>
    		 	      @else
    		 	        <p>Need recertification</p>
    		 	      @endif
    		 	   <?php
    		 	   }
    		 	   else{
    		 	   	?>
    		 	   	<p> Not Uploaded</p>
    		 	   <?php
    		 	   }
    		 	   ?>
  	 	  		</td>
  	 	  		<td id="plan{{$item['shopid']}}">
    		 	  <?php
    		 	   if(isset($item['plan'])){
    		 	   	?>
    		 	   	 {{$item['plan']}}
    		 	   <?php
    		 	   }else{
    		 	   	?>
    		 	   	 None
    		 	   <?php
    		 	   }
    		 	   ?>
  	 	  		</td>
  	 	  		<td id="status{{$item['shopid']}}">
    		     <?php
    		 	   if(isset($item['status'])){
    		 	   	 if($item['status'] == 0) {
    		 	   	 		?>
    		 	   	 		Active
    		 	   	 	<?php
    		 	   	 }
    		 	   	 else if($item['status'] == 1){
    		 	   	 	?>
    		 	   	 	  Expired
    		 	   	 	<?php
    		 	   	 }else{
    		 	   	 	?>
    		 	   	    No Active
    		 	   	 	<?php
    		 	   	 }		 	  		 	
    		 	   }else{
    		 	   	?>
    		 	   	 No Plan
    		 	   <?php
    		 	   }
    		 	   ?>
  	 	  		</td>
  	 	  		<td>
  	 	  		 	@if($item['valid'] == 'false')
  	 	  		 	  Not Valid
  	 	  		 	@elseif($item['valid'] == 'true')
  	 	  		 	  Valid
              @else
                No Register
  	 	  		 	@endif
  	 	  		</td>
  	 	  		<td class="save" id="save{{$item['shopid']}}" style="cursor: pointer;">
  	 	  		 	<i class="fa fa-save" style="pointer-events: none;"></i>
  	 	  		 	Save
  	 	  		</td>
  	 	  		<td class="edit" id="edit{{$item['shopid']}}" style="cursor: pointer;">
  	 	  		 <i class="fa fa-edit" style="pointer-events: none;"></i>
  	 	  		 	Edit
  	 	  		</td>
  	 	  	</tr>
  	 	    @endforeach
  	 	  </tbody>
  	 	</table>

 	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.foundation.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.jqueryui.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.semanticui.min.js"></script> 
<script type="text/javascript" src="{{asset('js/operator.js')}}"></script>
@endsection