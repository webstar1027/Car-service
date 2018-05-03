@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/confirmservice.css')}}">
@endsection
@section('scripts')
<script type="text/javascript" src="{{asset('js/confirmservice.js')}}"></script>
@endsection
@section('content')
   <div class="container">
     <div class="col-md-12">        
       <div class="panel panel-primary">
          <div class="panel-heading">           
              <h4> <i class="fa fa-cubes" aria-hidden="true"></i> Confirm Service </h4>           
          </div>
          <div class="panel-body">
              <!-- this part is for category selection -->
            <div class="row">
              <div class="col-md-10 col-md-offset-1 category-select-part" style="margin-bottom:30px;display: block;">
                  <div class="text-center">
                     <h4> <?php echo session()->get('masterservice_name');?>  <small> ({{$services_data[0]['category_name']}})</small></h4>
                  </div>
              </div> 
            </div>            
              <!-- service information -->
            <div class="row">
              <div class="table-responsive">
                <table class="table table-inverse table-bordered" id="service_body"> 
                   <thead>
                    <tr>
                      <td>No</td>                
                      <td>Year</td>
                      <td>Make</td>
                      <td>Model</td>
                      <td>Term</td>
                      <td>Lowest level Service Name</td>
                      <td>Minutes to complete Service</td>
                      @if(gettype($costs[0]) == 'string')
                        <?php
                         $count = count($costs);
                         ?>
                         @for($i =0 ; $i < $count; $i++)
                           <td>Item{{$i+1}} Price</td>
                         @endfor
                      @else
                        <?php
                         $count = count($costs[0])
                         ?>
                          @for($i =0 ; $i < $count; $i++)
                           <td>Item{{$i+1}} Price</td>
                         @endfor
                      @endif              
                      <td>Total Service Price</td>
                      <td>Service  Schedualing Option</td>
                      <td>Status</td>
                      <td>Edit</td>
                      <td>Delete</td>                   
                    </tr>
                   </thead>
                   <tbody>          
                      <?php $count = 1 ;?>    
                      @foreach($services_data as $item)
                        <?php if($count>count($services_data)) break;?>
                       <tr id="{{$item['id']}}">
                         <td>{{$count}}</td>
                         <td>{{$item['year']}}</td>
                         <td>{{$item['make']}}</td>
                         <td>{{$item['model']}}</td>
                         <td>{{$item['term']}}</td>
                         <td>{{$item['category_name']}}</td>                      
                         <td id="complete_time{{$item['id']}}">{{$item['complete_time']}}</td>                                           
                         @if(gettype($costs[0]) == 'string')
                           @foreach($costs as $item1)
                           <td>{{$item1}}</td>
                           @endforeach
                         @else
                           @foreach($costs[$count-1] as $item2)
                           <td>{{$item2}}</td>
                           @endforeach
                         @endif
                         <td id="total{{$item['id']}}">{{$total_price[$count-1]}}</td>
                         <td>{{$item['service_schedule']}}</td>                       
                         @if($item['status'] == "Good")
                          <td style="background-color:#c6efce; color:#006100;"> {{$item['status']}}</td>
                         @else
                          <td style="background-color:#ffc7ce; color:#9c0006;"> {{$item['status']}}</td>
                         @endif
                         <td class="edit" id="edit{{$item['id']}}"><i class="fa fa-edit edit"></i>edit</td>
                         <td class="delete" id="delete{{$item['id']}}"><i class="fa fa-trash"></i>delete</td>           
                      </tr>
                       <?php $count ++ ;?>  
                      @endforeach
                  </tbody>
               </table>
              </div>
             </div>
             <div class="text-center">
              <?php $total_number = count($services_data);?>
           
              <a class="btn btn-primary" id="multiservice_create" href="{{route('service.confirm', ['masterservice_name' => $services_data[0]['category_name'], 'childservice_number' => $total_number])}}"> confirm <i class="fa fa-check-circle"></i></a>
             </div>
          </div>
       </div>
      </div>      
   </div>
@endsection