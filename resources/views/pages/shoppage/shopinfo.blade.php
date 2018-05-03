@extends('layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/shopinfo.css')}}">
@endsection

@section('content')
<div class="container">
	<div class="col-md-7 col-md-offset-2 part">
		<form role="form" id="shopinfo_form" action="{{url('/shop/info/update')}}" method="POST" class="form-horizontal">
			<div class="form-group">			
    		<label> Shop Street Address: </label> </td>
    		<input type="text" class="form-control" name="street" value="{{$street}}"/>
		    </div>
		    <div class="form-group">
	    		<label> Shop City:</label> 
	    		<input type="text" class="form-control" name="city" value="{{$city}}"/>
	    	</div>
	      <div class="form-group">	      
		  		<label> Shop State:</label> 
		  		<input type="text" class="form-control" name="province" value="{{$province}}"/>
		  	</div>
		  	<div class="form-group">	      
	    		<label> Shop Zip Code:  </label> 
	    		<input type="text" class="form-control" name="postal_code" value="{{$postal_code}}"/>
		    </div>
		    <div class="form-group">	      
	    		<label> Shop Phone Number: </label> 
	    		<input type="text" class="form-control" name="phone_number" value="{{$phone_number}}"/>
	    	</div> 
	    	<div class="form-group">
	    		<input type="hidden" name="id" value="{{$id}}">
	    	</div>
			<div class="text-center">
			  <input type="submit" class="btn btn-primary">
			</div>
		</form>
	</div>
</div>
@endsection

@section('scripts')
<script src="{!! URL::asset('lib/bootstrap/dist/js/bootstrap.min.js') !!}"></script>
<script src="{!! URL::asset('lib/bootstrapvalidator/dist/js/bootstrapValidator.min.js') !!}"></script>
<script type="text/javascript" src="{{asset('js/shopinfo.js')}}"></script>
@endsection