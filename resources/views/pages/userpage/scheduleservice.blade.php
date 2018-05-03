@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/schedule.css')}}">
@endsection
@section('scripts')
<script type="text/javascript" src="{{asset('js/schedule.js')}}"></script>
@endsection
@section('content')
  <div class="container-fluid">	     
     <div class="col-md-8 col-md-offset-2">
       
       <div class="appointment-status">
         <h4>Appointment Status &nbsp <i class="fa fa-commenting" aria-hidden="true"></i></h4>
         <?php
          $today = date('Y-m-d', strtotime('now'));
          $date = new DateTime($today);
          $week = (int)($date->format("W"));
         ?>
         <select class="form-control" id="appoint">          
            <?php
             if(isset($option_text)){
             ?>
              <option selected hidden> {{$option_text}} </option> 

             <?php
             }             
             else{
              ?>
              <option selected hidden> All Appointment </option>
             <?php
             }
             ?>
            <option value="0">All Appointment</option>
            <option value="<?php echo 1+$week ; ?>">Next Week Appointment</option>
            <option value="<?php echo 2+$week ; ?>">Next 2 Weeks Appointment</option>
            <option value="<?php echo 3+$week ; ?>">Next 3 Weeks Appointment</option>
            <option value="<?php echo 4+$week ; ?>">Next 4 Weeks Appointment</option>
            <option value="<?php echo 5+$week ; ?>">Next 5 Weeks Appointment</option>
            <option value="<?php echo 6+$week ; ?>">Next 6 Weeks Appointment</option>            
         </select>
       </div>
     
       <div class="week-appointment" style="margin-top: 30px;">
         <div class="table-responsive">               
           <table class="table table-striped table-inverse table-bordered">
             <thead class="thead-inverse">
               <tr>
                 <td> Service ID</td>
                 <td> Service Name </td>
                 <td> Appointment Time  </td>
                 <td> Duration </td>
                 <td> Shop Name </td>
                 <td> Car Description </td>
                 <td> Car Info </td>              
               </tr>
             </thead>
             <tbody id="all">
               @foreach($event_data as $item)
               <tr>
                 <td style="cursor: pointer;" onclick="location.href='/shop/service/detail/{{$item['service_id']}}'">{{$item['service_id']}}</td>
                 <td style="cursor: pointer;" onclick="location.href='/service/detail/{{$item['service_id']}}/{{$item['event_id']}}'">{{$item['event_name']}}</td>
                 <td>{{$item['start_time']}}</td>
                 <td>{{$item['duration']}} min</td>
                 <td>{{$item['shop_name']}}</td>
                 <td>{{$item['description_name']}}</td>
                 <td>{{$item['year']}} &nbsp {{$item['make']}} &nbsp {{$item['model']}} &nbsp{{$item['term']}}</td>
               
               </tr>
               @endforeach
             </tbody>
           </table>      
          </div> 
      </div>
    </div>
  </div>
</div>
@endsection

