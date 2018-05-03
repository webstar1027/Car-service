
@extends('layouts.shopowner')
@section('content')
<style>
	.col-md-8 p {
		text-align: justify;
	}
</style>
  <div class="col-md-8 col-md-offset-2">
  	<?php
  	  $user_id = session()->get('shopownercreate');
  	  session()->forget('shopownercreate');
  	  if(isset($user_id)) {
  	  	?>
  	  	<p>Thank You for Creating a Shop Owner Account with Maintfy! </p>
  	  	<p>Someone from Maintfy will contact you regarding the next steps, we need to validate the uploaded documents before we can move to next steps. You can login into your account to check the verification status of your uploaded documents.  This process can take up to 24 hours. </p>
  	  	<?php
  	  	}else{
  	  		?>
  	  		 <p>Sign up Today ! List your services on our Platform for starting at $9.99 per month. Increase your Sales. !</p>
  	    <?php
  	  	}
  	  	?>

  	
   
    <p>Maintfy California Listings Only Plan  requires Annual subscription for $120 Dollars a year (about $9.99 per month) excludes taxes and other fees. Increase in sales is not guaranteed. Maintfy is a new low price automotive listings platform.  Services only available in California. Avoid where prohibited. Please read our terms of use agreement on our website for more details. </p>
   </div>
@endsection