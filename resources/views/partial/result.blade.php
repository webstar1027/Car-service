@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/searchresult.css')}}">
@endsection
@section('scripts')
<script type="text/javascript" src="{{asset('js/searchresult.js')}}"></script>
@endsection
@section('content')
  <div class="container">
     <div class="col-md-12">            
        <div class="panel panel-primary">
            <div class="panel-heading">                 
                  <h4> <i class="fa fa-search"></i> Service Result</h4>                 
            </div>
            <div class="panel-body">
               <!-- search result -->
               <div class="row" id="service_name">
                <h3 style="text-align: center;">{{$services[0]['category_name']}}</h3>
                <div id="map" style="width:100%;height:350px;">
                </div>               
               </div>               
               <?php 
                $count= count($services);
                $count1 = 1;
                ?>
               <input type="hidden" id="number" value="{{$count}}">
               @foreach($services as $service)               
               <div class="row search-result" onclick="location.href='{{route('shopinformation', ['id' => $service['serviceofshop_id']])}}'">
                 <input type="hidden" id="lat{{$count1}}" value="{{$service['latlong']['lat']}}">
                 <input type="hidden" id="long{{$count1++}}" value="{{$service['latlong']['lng']}}">
                 <div class="form-group">
                   <ul>
                     <li><small>{{$service['shop_name']}} shop  {{$service['location']}}</small></li>
                     <li><small>Shop Phone number: </small> {{$service['shop_number']}}</li>
                     <li><small> Rating: </small> 
                       @if($service['rating'] == 5) 
                         <span class="rating-star"></span><span class="rating-star"></span><span class="rating-star"></span><span class="rating-star"></span><span class="rating-star"></span>
                       @elseif($service['rating'] == 4)
                           <span class="rating-star"></span><span class="rating-star"></span><span class="rating-star"></span><span class="rating-star"></span><span class="rating-star-empty"></span>
                       @elseif($service['rating'] == 3)
                           <span class="rating-star"></span><span class="rating-star"></span><span class="rating-star"></span><span class="rating-star-empty"></span><span class="rating-star-empty"></span>
                       @elseif($service['rating'] == 2)
                           <span class="rating-star"></span><span class="rating-star"></span><span class="rating-star-empty"></span><span class="rating-star-empty"></span><span class="rating-star-empty"></span>
                       @elseif($service['rating'] == 1)
                          <span class="rating-star"></span><span class="rating-star-empty"></span><span class="rating-star-empty"></span><span class="rating-star-empty"></span><span class="rating-star-empty"></span>
                     

                       @endif
                      </li>
                     <li><small>Price:  </small> ${{$service['price']}}</li>
                   </ul>
                </div>
               </div>
               @endforeach            
        </div>
        
         <div class="form-group">
            <a class="col-md-2 col-md-offset-5 btn btn-primary service-back" href="{{route('search.back')}}">back <i class="fa fa-back" aria-hidden="true"></i></a>
         </div>              
   </div>
</div>  
@endsection
