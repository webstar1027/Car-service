@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/bookappointment.css')}}">
@endsection
@section('content')
<div class="container">
   <div class="col-md-8 col-md-offset-2">       
     <div class="appointment-status" style="margin-bottom: 40px;">
       <h4>Appointment: </h4>
       <?php
        $today = date('Y-m-d', strtotime('now'));
        $date = new DateTime($today);
        $week = (int)($date->format("W"));

        $year =  date('Y');
        $lastday = date('Y-m-d', strtotime($year.'-12-28'));
        $lastdate = new DateTime($lastday);
        $lastweek = (int)($lastdate->format("W"));

        $week0 = 0 + $week;$week1 = 1 + $week;$week2 = 2 + $week;$week3 = 3 + $week;$week3 = 3 + $week;$week4 = 4 + $week;$week5 = 5 + $week;
        $week6 = 6 + $week;
        if($week1 > $lastweek) { $week1 = $week1-$lastweek; $year1 = $year + 1;} else $year1 = $year;
        if($week2 > $lastweek) { $week2 = $week2-$lastweek; $year2 = $year + 1;} else $year2 = $year;
        if($week3 > $lastweek) { $week3 = $week3-$lastweek; $year3 = $year + 1;} else $year3 = $year;
        if($week4 > $lastweek) { $week4 = $week4-$lastweek; $year4 = $year + 1;} else $year4 = $year;
        if($week5 > $lastweek) { $week5 = $week5-$lastweek; $year5 = $year + 1;} else $year5 = $year;
        if($week6 > $lastweek) { $week6 = $week6-$lastweek; $year6 = $year + 1;} else $year6 = $year;
       ?>
       <select class="form-control" id="appoint">    
        <?php
         if(isset($option)) {
          ?>
           <option selected hidden> {{$option}}</option>   
        <?php
         }
         else{
          ?>
          <option selected hidden></option>
          <?php
         }
         ?>            
        <option value="{{$year}}-{{$week0}}"> This Week</option>
        <option value="{{$year1}}-{{$week1}}"> Next Week</option>
        <option value="{{$year2}}-{{$week2}}"> In 2 Weeks</option>
        <option value="{{$year3}}-{{$week3}}"> In 3 Weeks</option>
        <option value="{{$year4}}-{{$week4}}"> In 4 Weeks</option>
        <option value="{{$year5}}-{{$week5}}"> In 5 Weeks</option>   
        <option value="{{$year6}}-{{$week6}}"> In 6 Weeks</option>                   
       </select>
     </div>
     <input type="hidden" id="serviceofshop_id" value="{{$id}}">
   </div>
   <div class="col-md-8 col-md-offset-2">    
     <div class="week-appointment">
      <?php if(isset($shop_available_time))  $keys = array_keys($shop_available_time);?>
      <div class="weekday" data-toggle="collapse" href="#Monday" aria-expanded="false" aria-controls="Monday">Monday</div>    
      <div class="collapse" id="Monday">
       <?php if(isset($shop_available_time)){
        ?>
         <table class="table">
           <tbody>
           <?php $count_monday = 0; ?>
           @foreach($shop_available_time[$keys[0]] as $item)
            <tr>
              <td> <label> {{$keys[0]}} &nbsp &nbsp at &nbsp{{$item}}</label>  &nbsp &nbsp             
               <input id="monday{{$count_monday}}" type="checkbox" value="{{$keys[0]}} {{$item}}" />
               <label for="monday{{$count_monday}}"></label> 
              </td>
            </tr>
           <?php $count_monday++;?>
           @endforeach
           </tbody>
          </table>
          <?php
       }
       ?>
      </div>   
      <div class="weekday" data-toggle="collapse" href="#Tuesday" aria-expanded="false" aria-controls="Tuesday" >Tuesday</div>     
       <div class="collapse" id="Tuesday">
       <?php if(isset($shop_available_time)){
        ?>
         <table class="table">
           <tbody>
           <?php $count_tuesday = 0;?>
           @foreach($shop_available_time[$keys[1]] as $item)
            <tr>
              <td> <label> {{$keys[1]}} &nbsp &nbsp at &nbsp{{$item}}</label>  &nbsp &nbsp             
               <input id="tuesday{{$count_tuesday}}" type="checkbox" value="{{$keys[1]}} {{$item}}" />
               <label for="tuesday{{$count_tuesday}}"></label> 
              </td>
            </tr>
            <?php $count_tuesday++;?>
           @endforeach
           </tbody>
          </table>
          <?php
       }
       ?>
      </div>    
      <div class="weekday" data-toggle="collapse" href="#Wednesday" aria-expanded="false" aria-controls="Wednesday">Wednesday</div>    
       <div class="collapse" id="Wednesday">
       <?php if(isset($shop_available_time)){
        ?>
         <table class="table">
           <tbody>
           <?php $count_wednesday = 0; ?>
           @foreach($shop_available_time[$keys[2]] as $item)
            <tr>
              <td> <label> {{$keys[2]}} &nbsp &nbsp at &nbsp{{$item}}</label>  &nbsp &nbsp             
               <input id="wednesday{{$count_wednesday}}" type="checkbox" value="{{$keys[2]}} {{$item}}" />
               <label for="wednesday{{$count_wednesday}}"></label> 
              </td>
            </tr
           <?php $count_wednesday++;?>
           @endforeach
           </tbody>
          </table>
          <?php
       }
       ?>
      </div>        
      <div class="weekday" data-toggle="collapse" href="#Thursday" aria-expanded="false" aria-controls="Thursday">Thursday</div>       
       <div class="collapse" id="Thursday">
       <?php if(isset($shop_available_time)){
        ?>
         <table class="table">
           <tbody>
           <?php $count_thursday = 0;?>
           @foreach($shop_available_time[$keys[3]] as $item)
            <tr>
              <td> <label> {{$keys[3]}} &nbsp &nbsp at &nbsp{{$item}}</label>  &nbsp &nbsp             
               <input id="thursday{{$count_thursday}}" type="checkbox" value="{{$keys[3]}} {{$item}}" />
               <label for="thursday{{$count_thursday}}"></label> 
              </td>
            </tr>
          <?php $count_thursday++;?>
           @endforeach
           </tbody>
          </table>
          <?php
       }
       ?>
      </div>        
      <div class="weekday" data-toggle="collapse" href="#Friday" aria-expanded="false" aria-controls="Friday">Friday</div>     
       <div class="collapse" id="Friday">
       <?php if(isset($shop_available_time)){
        ?>
         <table class="table">
           <tbody>
           <?php $count_friday = 0;?>
           @foreach($shop_available_time[$keys[4]] as $item)
            <tr>
              <td> <label> {{$keys[4]}} &nbsp &nbsp at &nbsp{{$item}}</label>  &nbsp &nbsp             
               <input id="friday{{$count_friday}}" type="checkbox" value="{{$keys[4]}} {{$item}}" />
               <label for="friday{{$count_friday}}"></label> 
              </td>
            </tr>
          <?php $count_friday++;?>
           @endforeach
           </tbody>
          </table>
          <?php
       }
       ?>
      </div>           
      <div class="weekday" data-toggle="collapse" href="#Saturday" aria-expanded="false" aria-controls="Saturday">Saturday</div>    
       <div class="collapse" id="Saturday">
       <?php if(isset($shop_available_time)){
        ?>
         <table class="table">
           <tbody>
           <?php $count_saturday = 0;?>
           @foreach($shop_available_time[$keys[5]] as $item)
            <tr>
              <td> <label> {{$keys[5]}} &nbsp &nbsp at &nbsp{{$item}}</label>  &nbsp &nbsp             
               <input id="saturday{{$count_saturday}}" type="checkbox" value="{{$keys[5]}} {{$item}}" />
               <label for="saturday{{$count_saturday}}"></label> 
              </td>
            </tr>
           <?php $count_saturday++;?>
           @endforeach
           </tbody>
          </table>
          <?php
       }
       ?>
      </div>             
      <div class="weekday" data-toggle="collapse" href="#Sunday" aria-expanded="false" aria-controls="Sunday">Sunday</div>    
       <div class="collapse" id="Sunday">
       <?php if(isset($shop_available_time)){
        ?>
         <table class="table">
           <tbody>
           <?php $count_sunday = 0;?>
           @foreach($shop_available_time[$keys[6]] as $item)
            <tr>
              <td> <label> {{$keys[6]}} &nbsp &nbsp at &nbsp{{$item}}</label>  &nbsp &nbsp             
               <input id="sunday{{$count_sunday}}" type="checkbox" value="{{$keys[6]}} {{$item}}" />
               <label for="sunday{{$count_sunday}}"></label> 
              </td>
            </tr>
           <?php $count_sunday++;?>
           @endforeach
           </tbody>
          </table>
          <?php
       }
       ?>
      </div>             
       
      <div class='modal fade' id='myModal' role='dialog' data-keyboard='false' data-backdrop='static'>
        <div class='modal-dialog' role='document'>                             
          <div class='modal-content'>     
            <div class='modal-header'>
             <i class='fa fa-close' id="close" data-dismiss='modal' style='float:right;cursor:pointer;'></i>
            
            </div>       
            <div class='modal-body'>            
               Please select only one time window for your service appointment.
            </div>    
            <div class="modal-footer">                  
            </div>                             
          </div>
        </div>
      </div>

       <div class='modal fade' id='myModal1' role='dialog' data-keyboard='false' data-backdrop='static'>
        <div class='modal-dialog' role='document'>                             
          <div class='modal-content'>     
              <div class='modal-header'>
               <i class='fa fa-close' id="close" data-dismiss='modal' style='float:right;cursor:pointer;'></i>
              
              </div>       
              <div class='modal-body'>            
                 Please select one time window for your service appointment.
              </div>    
              <div class="modal-footer">                  
              </div>                             
          </div>
        </div>
      </div>
    
      
     <div class="text-center" style="margin-bottom: 40px; margin-top: 40px;">
      <button class="btn btn-primary" id="booking" style="margin-bottom: 25px;">Submit</button>
     </div>
   </div>
</div>
@endsection
@section('scripts')
<script src="{!! URL::asset('lib/bootstrap/dist/js/bootstrap.min.js') !!}"></script>
<script src="{!! URL::asset('lib/bootstrapvalidator/dist/js/bootstrapValidator.min.js') !!}"></script>
<script type="text/javascript" src="{{asset('js/bookappointment.js')}}"></script>
@endsection