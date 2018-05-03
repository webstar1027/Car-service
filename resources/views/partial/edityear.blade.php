@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/yearedit.css')}}">
@endsection
@section('scripts')
<script type="text/javascript" src="{{asset('js/yearedit.js')}}"></script>
@endsection
@section('content')
<?php $limit = session()->get('limit');?>
   <div class="container">
     <div class="col-md-12">        
       <div class="panel panel-primary">
          <div class="panel-heading">           
              <h4> <i class="fa fa-hand-pointer-o" aria-hidden="true"></i> Select one or more years of vehicle ( Maximum of {{$limit['limit_year']}} years can be selected)</h4>           
          </div>
          
          <input type="hidden" id="year_limit" value="{{$limit['limit_year']}}">
          <div class="panel-body">
              <div id="car_year">
               <?php
                for($i = 1980; $i < 2020; $i++){
                  ?>                        
                    <input id="year{{$i}}" type="checkbox" value="{{$i}}" />
                    <label for="year{{$i}}" style="padding-left:40px;">{{$i}}</label>                               
                  <?php
                }
                ?>
              </div>
              <div class="col-md-3 col-md-offset-5">
                <button class="btn btn-primary" style="margin-top:30px;" id="make_selection"> Next <i class="fa fa-hand-pointer-o" aria-hidden="true"></i></button>
              </div>
          </div>
       </div>
      </div> 
      <div class="text-center">
        <span class="rating"></span>&nbsp<span id="text-inform">Click next to select make of vehicle(s)</span>
      </div>     
   </div>

   <div class="remodal" data-remodal-id="modal" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
    <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
      <div>
        <h2 id="modal1Title">Warning</h2>
        <p id="modal1Desc">
           You must select one year at least !
        </p>
      </div>
    <br>
    <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
    <button data-remodal-action="confirm" class="remodal-confirm">OK</button>
  </div>
  <div class="remodal" data-remodal-id="modal1" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
    <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
      <div>
        <h2 id="modal1Title">Warning</h2>
        <p id="modal1Desc">
          
           Maximum {{$limit['limit_year']}} year can be selected!
        </p>
      </div>
    <br>
    <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
    <button data-remodal-action="confirm" class="remodal-confirm">OK</button>
  </div>
@endsection