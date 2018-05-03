@extends('layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/shopcalendar.css')}}">
@endsection

@section('scripts')
<script type="text/javascript" src="{{asset('js/shopcalendar.js')}}"></script>

@endsection
@section('content')
<div class="container">
  <div class="col-md-7 col-md-offset-2">
    <div class="part">
    	<?php 
       if(count($events) > 0){
        ?>
        <legend>My calendar (for 30 days)</legend>
        <bold>Action: {{$events[0]['shop_name']}} always busy</bold>
        @foreach($events as $event)
          <?php 
          $day = date("l", strtotime($event['start_time']) );
          $start = date("h:i A", strtotime($event['start_time']));        
          $end = date("h:i A", strtotime("+".intval($event['duration'])." minutes", strtotime($start)));
          ?>
          <p> {{$day}} &nbsp; <?php echo date('M/d/y', strtotime($event['start_time']));?></p>
          <p> {{$start}}&nbsp;to &nbsp;{{$end}}&nbsp;&nbsp;{{$event['event_name']}}</p>
        @endforeach
        <?php
       }
       else{
        ?>
         <p> Your shop did not register any service!.
        <?php
       }
      ?>
    </div>
  </div>
</div>
@endsection