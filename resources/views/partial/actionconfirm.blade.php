@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/actionconfirm.css')}}">
@endsection
@section('scripts')
<script type="text/javascript" src="{{asset('js/actionconfirm.js')}}"></script>
@endsection
@section('content')
  <div class="container">
      <div class="action-text">
         <p>Please confirm: you want to {{$action_name}} below services </p>             
      </div>
      <div class="form-group">
        <div class="table-responsive">
         <table class="table table-inverse table-bordered" id="price_body">
             <thead class="thead-inverse">
               <tr>                
                 <td>Service ID</td>
                 <td>Child Service Name</td>
                 <td>Year</td>
                 <td>Make</td>
                 <td>Model</td>
                 <td>Term</td>
                 <?php $count = count($items[0]);?>
                 @for($i=0;$i<$count;$i++)
                  <td>Item {{$i+1}} Price</td>
                 @endfor
                 <td>Total price</td>
                 <td>Status</td>                 
               </tr>
             </thead>
             <tbody>
               <?php $count1 = count($childservices);?>
               
               @for($i=0;$i<$count1;$i++)                            
                 <tr id="{{$childservices[$i]['serviceofshop_id']}}">                   
                   <td>{{$childservices[$i]['serviceofshop_id']}}</td>
                   <td>{{$childservices[$i]['category_name']}}</td>
                   <td>{{$childservices[$i]['year']}}</td>
                   <td>{{$childservices[$i]['make']}}</td>
                   <td>{{$childservices[$i]['model']}}</td>
                   <td>{{$childservices[$i]['term']}}</td>    
                   <?php $count3=1;?>                   
                   @foreach($items[$i] as $childitem)
                     <td>{{$childitem}}</td>
                   @endforeach
                   <td id="total{{$childservices[$i]['serviceofshop_id']}}">{{$childservices[$i]['total_price']}}</td>
                   @if($childservices[$i]['status'] == 0 )
                     <td> active </td>
                   @elseif($childservices[$i]['serviceofshop_id'] == 1)
                     <td> expire </td>
                   @else
                     <td> deactive </td>
                   @endif                       
                 </tr>                      
               @endfor
             </tbody>
          </table>
        </div>
      </div>
      <div class="text-center">
        <button class="btn btn-primary" onclick="location.href='{{route('confirm.finish')}}'">Confirm</button>
        <button class="btn btn-primary" onclick="location.href='{{route('action.back')}}'">Back</button>
      </div>
  </div>  
@endsection
