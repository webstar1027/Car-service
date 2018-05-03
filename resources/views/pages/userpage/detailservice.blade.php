@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/shopdetail.css')}}">
@endsection
@section('scripts')
<script type="text/javascript" src="{{asset('js/shopdetail.js')}}"></script>
@endsection
@section('content')
   <div class="container">
      <div class="col-md-12">
         <div class="shop-detail">
           <div class="form-group">       
             <small>Shop Info:</small>      
             <p>{{$services['shop_name']}}</p>          
             <p>{{$fulladdress['street']}}</p>          
             <p>{{$fulladdress['city']}} &nbsp {{$fulladdress['province']}}{{$fulladdress['postal_code']}} &nbsp {{$fulladdress['country']}}</p>          
             <p>{{$services['shop_phonenumber']}}</p>
           </div>
           </br>
         
           <div class="form-group">
             <small>Your Car:</small>
             <p>{{$services['year']}} {{$services['make']}} {{$services['model']}} {{$services['term']}}</p>
             <p>Current mileage: <?php echo session()->get('current_mileage');?>  </p> 
           </div>

           <div class="form-group">
             <small> Service ID:</small>
             <p style="cursor: pointer;"> {{$services['serviceofshop_id']}}</p>
           </div>
           </br>
           <input type="hidden" id="event_id" value="{{$event['id']}}"/>
           <div class="form-group">
             <small>Action:</small>
             <p style="cursor: pointer;" id="service_cancel">Cancel Service</p>             
           </div>
           </br>
         
           <div class="form-group">
             <small>Time:</small>
             <p>{{$event['start_time']}} &nbsp {{$event['duration']}} min</p>             
           </div>
           </br>
       
           <div class="form-group">
             <small>Service Information:</small>
             <p>{{$services['category_name']}}</p>             
           </div>
           </br>
         
           <div class="form-group">
             <small>Service Details:</small>
             <p>{{$services['descriptions']}}</p>
           </div>  
           </br>
        
           <table class="table table-inverse table-bordered" class="table-responsive"> 
             <thead>
               <tr>
                 <td> No </td>
                 <td> Line Item Name </td>
                 <td> Description </td>
                 <td> Price </td>
               </tr>
             </thead>
             <tbody>
               <?php $count = 1;?>
               @foreach($lineitems as $lineitem)
                 <tr>
                   <td>{{$count++}}</td>
                   <td>{{$lineitem['pricetype_name']}}</td>
                   <td>{{$lineitem['description']}}</td>  
                   <td>${{$lineitem['price']}}</td>
               @endforeach
             </tbody>
           </table>           
           </br>
          
           <div class="form-group">            
            @foreach($price as $item)
             @if(key($item) == 'labor price')                 
              <?php $labor_price = intval(current($item));?>
             @elseif(key($item) == 'regulation fees')  
              <?php $regulation_fees = intval(current($item));?>    
             @endif          
            @endforeach               
            <?php
              if (isset($labor_price)) {
                ?>
                <small>Total Labor Price: </small><p> ${{$labor_price}}</p>
                <?php
              }else{
                ?>
                <small>Total Labor Price: </small><p> $0</p>
                <?php
              }
              ?>           
            <?php
             if(isset($labor_price) && isset($regulation_fees)) {
              ?>
              <small>Total Parts Price: </small><p>$<?php echo (intval($services['total_price']) - $labor_price - $regulation_fees);?></p>
              <?php
             }elseif (isset($labor_price) && !isset($regulation_fees)) {
              ?>
               <small>Total Parts Price:</small><p>$<?php echo (intval($services['total_price']) - $labor_price)?></p>
              <?php
             }elseif (!isset($labor_price) && isset($regulation_fees)) {
              ?>
              <small>Total Parts Price: </small><p>$<?php echo (intval($services['total_price']) - $regulation_fees);?></p>
              <?php
             }else{
               ?>
              <small>Total Parts Price: </small><p>$<?php echo intval($services['total_price']);?></p>
              <?php
             }
             ?>
           </div>
           </br>
         
           <div class="form-group">
             <small>Total Price </small>   <p>${{$services['total_price']}}</p>       
           </div>
           <div class="form-group">
             <small>Mainfty Disclaimer:</small>
             <p>3</p>
           </div>
           <div class="form-group">
             <small>Shop Disclaimer</small>
             <p>{{$services['shop_declaimer']}}</p>
           </div>
           
          
         <div class="text-center" style="margin-top:40px;">
           <a class="btn btn-primary" href="{{route('schedule')}}">back</a>
         </div>

           <div class='modal fade' id='myModal' role='dialog' data-keyboard='false' data-backdrop='static'>
            <div class='modal-dialog' role='document'>                             
                <div class='modal-content'>     
                    <div class='modal-header'>
                     <i class='fa fa-close' data-dismiss='modal' style='float:right;cursor:pointer;'></i>                    
                    </div>       
                    <div class='modal-body'>            
                      Are you sure you want to cancel service?
                    </div>    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default cancel_confirm" data-dismiss="modal">Yes</button>
                        <button type="button" class="btn btn-default cancel" data-dismiss="modal">No</button>
                    </div>                             
                </div>
            </div>
          </div>
      </div>
   </div>
@endsection