@extends('layouts.shopowner')
@section('content')
 <style>
   .col-md-6 { 
    margin-top:100px;   
   }
 </style>
 <div class="container">
   <div class="col-md-6 col-md-offset-3">
    <div class="panel panel-primary">
      <div class="panel-heading">
         Shopower Login
      </div>
      <div class="panel-body">
        <form method="post" action="{{route('shopowner.login')}}" class="form-horizontal">
           <div class="row">
             <label class="control-label col-md-5" for="email"> Email Address </label>
             <div class="col-md-7">
               <input type="text" name="email" class="form-control" required autofocus/>
             </div>
           </div>
           </br>
           <div class="row">
             <label class="control-label col-md-5" for="password"> Password </label>
             <div class="col-md-7">
               <input type="password" name="password" class="form-control" required autofocus/>
             </div>
           </div>   
          
           </br>
           </br>
           <div class="row text-center">
             <input type="submit" class="btn btn-primary" value="Login"/>
             <a class="btn btn-link" href="{{ route('password.request') }}">
                                          Forgot Your Password?
             </a>
           </div>
          </form>
      </div>
    </div>
   </div>
 </div>
@endsection