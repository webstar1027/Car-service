@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/mycar.css')}}">
@endsection
@section('scripts')
<script type="text/javascript" src="{{asset('js/mycar.js')}}"></script>
@endsection
@section('content')
  <div class="container">	
  	<div class="col-md-7 col-md-offset-2">
       <div class="table-responsive">
        <?php $count = 1;?>      
       <table class="table table-striped table-inverse table-bordered">
         <thead class="thead-inverse">
           <tr>
             <td> #</td>
             <td> Car Description Name</td>
             <td> Car Info</td>
           </tr>
         </thead>
       	 <tbody>
            @foreach($profiles as $profile)
           	 	<tr>
                <td> {{$count++}}</td>
           	 		<td>{{$profile['description_name']}}</td>
           	 		<td><a href="{{route('user.car', ['id' => $profile['userofcar_id']])}}">{{$profile['year']}} &nbsp  {{$profile['make']}} &nbsp  {{$profile['model']}}  &nbsp {{$profile['term']}}</a></td>       	 			 		
           	 	</tr>
           @endforeach    
         </tbody>
       </table>
      
      </div> 
    </div>
  </div>
 @endsection
