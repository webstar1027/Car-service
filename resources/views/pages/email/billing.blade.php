<?php
 $plan = session()->get('add_mail'); session()->forget('add_mail');?>
 <strong> You are receiving this email because we received a payment request for shopowner account.</strong>
<p> plan name :  California Listing Only Subscription Plan ${{$plan['amount']}} per Year</p>
<p> plan type : {{$plan['plantype']}}</p>


