@extends('layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/shopprofile.css')}}">
@endsection

@section('scripts')
<script type="text/javascript" src="{{asset('js/shopprofile.js')}}"></script>

@endsection
@section('content')
<div class="container">
  <div class="col-md-7 col-md-offset-2 shop_info">
	  <div class="row">
	 	  <div class="form-group">
	 	  	<legend> Shop Info</legend>
	 	  	<p>{{$shop_user['shop_name']}} Auto Services.</p>
	 	  	<p> {{$street}} </p>
	 	  	<p> {{$city}} &nbsp; {{$state}}{{$zip_code}}</p>
	 	  	<p> {{$shop_user['shop_phonenumber']}}</p>
        
	 	  	<a href="/shop/info/edit/{{$shop_user['shopofinfo_id']}}">Edit Shop Info </a>
	 	  </div>
	  </div>
  </div>
  <div class="col-md-7 col-md-offset-2 shop_info">
    <div class="row">
      <div class="form-group">
        <legend> Business Document Upload</legend>  
        <?php 
        if(count($file) > 0) {
        ?>
          <div class="document" style="padding:15px;">
            <table class="table table-hover table-bordered" style="width:100%; margin:5px auto;">
              <thead>
                <th>Document Type</th>
                <th>Document Name</th>
                <th>Upload Date</th>
                <th>Status</th>
              </thead>
              <tbody>
              @foreach($file as $item)
                <tr>
                  <td>
                    @if($item['file_type'] == 0)
                      Business Insurance
                    @else
                      Business License
                    @endif
                   </td>
                   <td>{{$item->file_name}}</td>
                   <td><?php echo date('M/d/y', strtotime($item->created_at));?></td>
                   <td>
                      @if($item['status'] == 0)
                        Review
                      @elseif($item['status'] == 1)
                        Valid
                      @else
                        Needs Update
                      @endif
                   </td>
                </tr>
               @endforeach                         
              </tbody>
            </table>
          </div>
          <?php
          }     
          ?>
          <a href="/document/upload">File Upload</a>
        </div>
     </div>
   </div>
   <div class="col-md-7 col-md-offset-2 shop_disclaimer">
  	 <div class="row">
  	 	  <div class="form-group">
  	 	  	<legend>Shop Disclaimer </legend>  
  	 	  	<p style="text-align: left; padding-left: 15px;">{{$shop_user['shop_declaimer']}}</p>	 	  	
  	 	  	<a href="/shop/disclaimer/edit/{{$shop_user['shopofinfo_id']}}">Edit Shop Disclaimer </a>
  	 	  </div>
  	 </div>
   </div>
   <div class="col-md-7 col-md-offset-2 shop_hour">  	
  	 	<legend style="text-align: center;">Shop Hour</legend> 	
      @foreach($hours as $hour)
        <div class="row">
          <div class="form-group">
            <span class="col-md-3">
            <?php switch($hour['dayofweek']){
                  case '0':
                  	echo "Monday";
                  	break;
                  case '1':
                  	echo "Tuesday";
                  	break;
                  case '2':
                  	echo "Wednesday";
                  	break;
                  case '3':
                  	echo "Thursday";
                  	break;
                  case '4':
                  	echo "Friday";
                  	break;
                  case '5':
                  	echo "Saturday";
                  	break;
                   case '6':
                  	echo "Sunday";
                  	break;
            	} 
            	?></span>            
              <span class="col-md-3">
                <?php 
                if(isset($hour['open_time'])) {
                  echo date('h:i A', strtotime($hour['open_time']));
                  ?>
                  </span>
                  <span class="col-md-3"> To</span>
                  <span class="col-md-3">
                  <?php echo date('h:i A', strtotime($hour['close_time']));?></span></p>
                  <?php
               
                }?>
              </div>
           </div>
          @endforeach
        </br>
  	 <a href="/shop/hour/edit/{{$shop_user['shopofinfo_id']}}">Edit Shop Hour </a>
  </div>
  <div class="col-md-7 col-md-offset-2 shop_block">	  	 
  	<legend>Block Schedule </legend>  
    <p>Always Block:</p>            
    @foreach($shopblocktimes as $item)
      @if($item['block_type'] == 0)
       <div class="row">
        <div class="form-group">
          <span class="col-md-4">Every &nbsp <?php echo $day= date("l", strtotime($item['block_date']) );?></span>
          <span class="col-md-4"><?php echo date('h:i A', strtotime($item['open_time']));?> to {{$item['close_time']}}</span>                     
          <span class="col-md-4">Description:{{$item['description']}}</span>     
        </div>
      </div>        
      @endif
    @endforeach	
    </br>  
    <p>One Time Block:</p> 
    @foreach($shopblocktimes as $item)
      @if($item['block_type'] == 1)              
       <div class="row">
         <div class="form-group">
           <span class="col-md-4"><?php echo $day= date("l", strtotime($item['block_date']) );?> &nbsp;<?php echo $day= date("M/d/y", strtotime($item['block_date']) );?></span>
           <span class="col-md-4"><?php echo date('h:i A', strtotime($item['open_time']));?> to {{$item['close_time']}}</span>
           <span class="col-md-4">Description:{{$item['description']}}</span>                    
         </div>
       </div>         
      @endif
    @endforeach      
    </br>             	  	
  	<a href="/shop/block_schedule/edit/{{$shop_user['shopofinfo_id']}}">Edit Block Schedule </a>
  </div>
</div>
@endsection