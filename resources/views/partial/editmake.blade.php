@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/makeedit.css')}}">
@endsection
@section('scripts')
<script type="text/javascript" src="{{asset('js/makeedit.js')}}"></script>
@endsection
@section('content')   
<?php $limit = session()->get('limit');?>
   <div class="container">
     <div class="col-md-12">        
       <div class="panel panel-primary">
          <div class="panel-heading">           
            <h4> <i class="fa fa-hand-pointer-o" aria-hidden="true"></i> Select one or more makes of vehicle(s) @if($limit['limit_make'] == 0) (No limit) @else (Maximum of {{$limit['limit_make']}}  makes can be selected) @endif</h4>           
          </div>
          
          <input type="hidden" id="make_limit" value="{{$limit['limit_make']}}">
          <div class="panel-body">
            <div id="make_year">
              @foreach($make as $item)                
                <input id="{{$item}}" type="checkbox" value="{{$item}}" />
                <label for="{{$item}}" style="padding-left:40px;">{{$item}}</label>                               
              @endforeach
            </div>
            <div class="col-md-3 col-md-offset-5">
              <button class="btn btn-primary" style="margin-top:30px;" id="make_selection"> Next <i class="fa fa-hand-pointer-o" aria-hidden="true"></i></button>
            </div>
          </div>
       </div>
      </div>  
      <div class="text-center">
        <span class="rating"></span>&nbsp<span id="text-inform">Click next to select model of vehicle(s)</span>
      </div>       
   </div>
   
   <div class="remodal" data-remodal-id="modal" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
    <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
      <div>
        <h2 id="modal1Title">Warning</h2>
        <p id="modal1Desc">
           You must select one make at least !
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
          
           Maximum {{$limit['limit_make']}} make can be selected 
        </p>
      </div>
    <br>
    <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
    <button data-remodal-action="confirm" class="remodal-confirm">OK</button>
  </div>
@endsection