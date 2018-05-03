@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/myprofile.css')}}">
@endsection
@section('scripts')
<script type="text/javascript" src="{{asset('js/myprofile.js')}}"></script>
@endsection
@section('content')
  <div class="container">	  	 
       <div class="panel panel-primary">
     	<div class="panel-heading">
     		<h4> <i class="fa fa-address-card" aria-hidden="true"></i> My Profile </h4>
     	</div>
     	<div class="panel-body">
     	  <div class="profile-content col-md-6 col-md-offset-3">
	     	   <table>
	     	   	 <tbody>
	     	   	 	<tr>
	     	   	 	  <td class="col-md-1 profile"> First Name </td>
	     	   	 	  <td class="col-md-1"> <input type="text" name="firstname" class="form-control" value="">
	     	   	 	</tr>
	     	   	 	<tr>
	     	   	 	  <td class="col-md-1 profile"> Last Name </td>
	     	   	 	  <td class="col-md-1"> <input type="text" name="firstname" class="form-control" value="">
	     	   	 	</tr>
	     	   	 	<tr>
	     	   	 	  <td class="col-md-1 profile"> Email Address </td>
	     	   	 	  <td class="col-md-1"> <input type="text" name="firstname" class="form-control" value="">
	     	   	 	</tr>
	     	   	 	<tr>
	     	   	 	  <td class="col-md-1 profile"> Manage Notification </td>
	     	   	 	  <td class="col-md-1"> <input type="text" name="firstname" class="form-control" value="">
	     	   	 	</tr>
	     	   	 	<tr>
	     	   	 	  <td class="col-md-1 profile"> Allow Service Notification </td>
	     	   	 	  <td class="col-md-1"> <input type="text" name="firstname" class="form-control" value="">
	     	   	 	</tr>
	     	   	
	     	   	 	<tr>
	     	   	 	  <td class="col-md-1 profile"> allow vechile future service  </td>
	     	   	 	  <td class="col-md-1"> <input type="text" name="firstname" class="form-control" value="">
	     	   	 	</tr>
	     	   	 	<tr>
	     	   	 	  <td class="col-md-1 profile"> Notifications </td>
	     	   	 	  <td class="col-md-1"> <input type="text" name="firstname" class="form-control" value="">
	     	   	 	</tr>
	     	   	 </tbody>
	     	   </table>
     	  </div>
     	</div>
     </div>
  </div>
 @endsection
