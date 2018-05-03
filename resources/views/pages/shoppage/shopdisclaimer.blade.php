@extends('layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/shopdisclaimer.css')}}">
@endsection

@section('content')
<div class="container">
    <div class="col-md-7 col-md-offset-2 part">
			<form role="form" id="shopdisclaimer_form" action="{{url('/shop/disclaimer/update')}}" method="POST" class="form-horizontal">
				<div class="form-group">			
	    		<label> Shop Disclaimer: </label> </td>	   
	    		<input type="hidden" id="disclaimer" value="{{$shopdisclaimer}}"/> 		
	    		<textarea  class="form-control" name="shopdisclaimer" rows="10" cols="100"></textarea>
		    </div>	    	
				<div class="text-center">
				  <input type="submit" class="btn btn-primary">
				</div>
				<div class="form-group">
	    		<input type="hidden" name="id" value="{{$id}}">
	    	</div>
			</form>
	</div>
</div>
@endsection
@section('scripts')

<script src="{!! URL::asset('lib/bootstrap/dist/js/bootstrap.min.js') !!}"></script>
<script src="{!! URL::asset('lib/bootstrapvalidator/dist/js/bootstrapValidator.min.js') !!}"></script>
<script type="text/javascript" src="{{asset('js/shopdisclaimer.js')}}"></script>
@endsection