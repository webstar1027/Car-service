@extends('layouts.app')
@section('css')
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300|Rokkitt:300" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{asset('css/shopownerscription.css')}}">
@endsection
@section('content') 
  <div class="contianer-fluid">
    <div class="col-md-8 col-md-offset-2">
      <div class="row">
       <legend>My Current Active Subscriptions</legend>      
        <?php
          if(isset($subscription_plan) > 0) {
          ?>
          <input type="hidden" id="subplan" value="{{$subscription_plan['subscription_plan']}}"/>
          @if($subscription_plan['status'] == 0)
          <table class="table">  
            <thead>       
              <tr>            
                <th scope="col">Subscription Plan</th>
                <th scope="col">Subscription Start Date</th>
                <th scope="col">Subscription End Date</th>
              </tr>    
            </thead>
              <tbody>             
                <tr>            
                  <td>California Listings with Scheduling Plan  ${{$subscription_plan['subscription_plan']}} per Year</td>
                  <td>{{$subscription_plan['start_date']}}</td>
                  <td>{{$subscription_plan['end_date']}}</td>
                </tr>                    
              </tbody>          
          </table> 
          @else
            <p style="font-size: 20px;"> Your payment status did not verified yet. Please wait for Maintfy team email. </p>
          @endif  
        <?php
        }
        else{
          ?>
          <p style="font-size: 20px;"> You did not select subscription plan. please select subscription plan </p>
          <?php
        }
        ?>    
        <p><i class="material-icons" style="font-size:20px; color:#0ae00f;">add_alert</i> &nbsp; To Add, Renew, or Upgrade a Subscription Plan :<a href="javascript:;" id="plan"> Click Here </a></p> 
          @if ($message = Session::get('success'))
          <div class="custom-alerts alert alert-success fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            {!! $message !!}
          </div>
          <?php Session::forget('success');?>
          @endif
          @if ($message = Session::get('refund'))
          <div class="custom-alerts alert alert-success fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            {!! $message !!}
          </div>
          <?php Session::forget('refund');?>
          @endif
          @if ($message = Session::get('error'))
          <div class="custom-alerts alert alert-danger fade in">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
              {!! $message !!}
          </div>
          <?php Session::forget('error');?>
          @endif
      </div>
      <div class="row subscription_plan" style="margin-top: 20px; display: none;">
         <form class="form-horizontal" method="POST" id="payment-form" role="form" action="{!! URL::route('addmoney.paypal') !!}" >
          {{ csrf_field() }}        
        <legend>Add, Renew or Upgrade Subscription Plan</legend>
        <div class="row part">
          <div class="col-md-1"></div>
          <div class="col-md-3"><p>Plan Change Type:</p></div>
          <div class="col-md-7">
            <input type="hidden" id="subscription_plan" value="{{$subscription_plan['subscription_plan']}}">
            <select class="form-control col-md-6" name="plantype">
              <option selected hidden></option>     
              @if(!isset($subscription_plan['subscription_plan']))  
              <option value="add"> Add </option>
              @endif     
            </select>
          </div>
          <div class="col-md-1"></div>
        </div>
        </br>
        <div class="row part">        
          <div class="col-md-1"></div>
          <div class="col-md-3"><p>Plan Name: </p></div>
          <div class="col-md-7">
           <select class="form-control" name="amount">
              <option selected hidden></option>                   
            
           </select>
          </div>
          <div class="col-md-1"></div>
        </div>     
        <div class="text-center" style="margin-top:30px;">
           <button type="submit" class="btn btn-primary" id="paypal"> Next </button>
        </div>
      </div>
      <div class="row" style="margin-top: 20px;">
       <legend>Billing History:</legend>
       <table class="table">  
        <thead>
          <tr>
            <th>Transaction Date</th>
            <th>Plan Change Type</th>
            <th>Transaction Description</th>
            <th>Charge Value</th>         
            <th>Charge Type </th>
            <th>Charge Method</th>
          </tr>
        </thead>
        <tbody> 
          @foreach($billing as $item1)
          <tr>
            <td>{{$item1['transaction_date']}}</td>
            <td>
               @if($item1['plan_change_type'] == 0) 
                 Add
               @elseif($item1['plan_change_type'] == 1)
                 Renew
               @elseif($item1['plan_change_type'] == 2)
                 Upgrade
               @else
                 Downgrade
               @endif
            </td>
            <td>{{$item1['transaction_description']}}</td>
            <td>${{$item1['charge_value']}}</td>      
            <td>
               @if($item1['charge_type'] == 0)
                 Credit
               @else
                 Debit
               @endif
            </td>
            <td>{{$item1['charge_method']}}</td>
          </tr> 
          @endforeach        
         </tbody>
        </table>
      </div>
    </div>
  </div>
  <script>
   $(document).ready(function(){  
     var flag = false;
     $(document).on('click', '#plan', function() {
       if(flag == false) {
        $('.subscription_plan').css({'display':'block', 'transition':'500ms'});
        flag = true;
       }
       else{
        $('.subscription_plan').css({'display':'none', 'transition':'500ms'});
        flag = false;
       }
     });  
     if($('#subscription_plan').val() == '480') {

      var newcell = $('select[name=plantype]').html("<option selected hidden></option><option value='renew'> Renew </option><option value='downgrade'> Downgrade</option");
      $('select[name=plantype]').append(newcell);
     }
     if($('#subscription_plan').val() == '120') {

      var newcell = $('select[name=plantype]').html("<option selected hidden></option><option value='renew'> Renew </option><option value='upgrade'> Upgrade</option");
      $('select[name=plantype]').append(newcell);
     }
     $('select[name=plantype]').on('change', function(){ 
      var plan = $('#subplan').val();
      if($('select[name=plantype] option:selected').val() == 'add'){
        var newcell = $('select[name=amount]').html('<option selected hidden></option><option value="120">California Listing only Plan  $120 per Year </option><option value="480">California Listings with Scheduling Plan  $480 per Year </option>');
        $('select[name=amount]').append(newcell);
      }
      else if($('select[name=plantype] option:selected').val() == 'renew') {
         var newcell = $('select[name=amount]').html("<option selected hidden></option><option value='"+ plan+"'>California Listings with Scheduling Plan  $"+plan+" per Year </option>");

          $('select[name=amount]').append(newcell);
      }
      else if($('select[name=plantype] option:selected').val() == 'downgrade'){
         var newcell = $('select[name=amount]').html('<option selected hidden></option><option value="120">California Listing only Plan  $120 per Year </option>');
          $('select[name=amount]').append(newcell);
      }
      else {
        var newcell = $('select[name=amount]').html('<option selected hidden></option><option value="480">California Listings with Scheduling Plan  $480 per Year </option>');
        $('select[name=amount]').append(newcell);
      }
     });

   });
  </script>
@endsection