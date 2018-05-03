
@extends('layouts.shopowner')
@section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('css/shopregister.css')}}">
@endsection
@section('content')
    <div class="col-md-8 col-md-offset-2" style="margin-top: 20px;">
     <div class="panel panel-primary">
       <div class="panel-heading">
         ShopOwner Register
       </div>
       <div class="panel-body">
          <form action="{{route('shopowner.register')}}" method="post" class="form-horizontal">
           {{ csrf_field() }}      
              

            <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
             
              <label class="control-label col-md-5" for="firstname"> Shop Admin/Owner First Name</label>
              <div class="col-md-7">
                <input type="text" class="form-control" name="firstname" placeholder="first name" required/>
                @if ($errors->has('firstname'))
                  <span class="help-block">
                      <strong>{{ $errors->first('firstname') }}</strong>
                  </span>
               @endif
              </div>
             
            </div>
             <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
             
              <label class="control-label col-md-5" for="lastname"> Last Name</label>
              <div class="col-md-7">
                <input type="text" class="form-control" name="lastname" placeholder="last name" required/>
                 @if ($errors->has('lastname'))
                  <span class="help-block">
                      <strong>{{ $errors->first('lastname') }}</strong>
                  </span>
               @endif
              </div>
             
            </div>
             <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
             
              <label class="control-label col-md-5" for="username"> User Name</label>
              <div class="col-md-7">
                <input type="text" class="form-control" name="username" placeholder="user name" required/>
                 @if ($errors->has('username'))
                  <span class="help-block">
                      <strong>{{ $errors->first('username') }}</strong>
                  </span>
               @endif
              </div>
             
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
             
              <label class="control-label col-md-5" for="email"> Email Address</label>
              <div class="col-md-7">
                <input type="text" class="form-control" name="email" placeholder="email address" required/>
                 @if ($errors->has('email'))
                  <span class="help-block">
                      <strong>{{ $errors->first('email') }}</strong>
                  </span>
               @endif
              </div>
             
            </div>

             <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
             
              <label class="control-label col-md-5" for="address"> Street Address</label>
              <div class="col-md-7">
                <input type="text" class="form-control" name="address" placeholder="street address" required/>
                 @if ($errors->has('address'))
                  <span class="help-block">
                      <strong>{{ $errors->first('address') }}</strong>
                  </span>
               @endif
              </div>
             
            </div>

             <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
             
              <label class="control-label col-md-5" for="city"> City</label>
              <div class="col-md-7">
                <input type="text" class="form-control" name="city" placeholder="city" required/>
                 @if ($errors->has('city'))
                  <span class="help-block">
                      <strong>{{ $errors->first('city') }}</strong>
                  </span>
               @endif
              </div>
             
            </div>

             <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
             
              <label class="control-label col-md-5" for="state"> State </label>
              <div class="col-md-7">
                <input type="text" class="form-control" name="state" placeholder="state" required/>
                 @if ($errors->has('state'))
                  <span class="help-block">
                      <strong>{{ $errors->first('state') }}</strong>
                  </span>
               @endif
              </div>
             
            </div>


            <div class="form-group{{ $errors->has('zipcode') ? ' has-error' : '' }}">
             
              <label class="control-label col-md-5" for="zipcode"> Zip Code</label>
              <div class="col-md-7">
               <input type="text" class="form-control" name="zipcode" placeholder="zip code" required/>
                @if ($errors->has('zipcode'))
                  <span class="help-block">
                      <strong>{{ $errors->first('zipcode') }}</strong>
                  </span>
               @endif
              </div>
             
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
             
              <label class="control-label col-md-5" for="password">Account Password</label>
              <div class="col-md-7">
                <input type="password" class="form-control" name="password" placeholder="account password" required/>
                 @if ($errors->has('password'))
                  <span class="help-block">
                      <strong>{{ $errors->first('password') }}</strong>
                  </span>
               @endif
              </div>
             
            </div>

            <div class="form-group{{ $errors->has('shopname') ? ' has-error' : '' }}">
             
              <label class="control-label col-md-5" for="shopname"> Shop Name</label>
              <div class="col-md-7">
                <input type="text" class="form-control" name="shopname" placeholder="shop name" required/>
                 @if ($errors->has('shopname'))
                  <span class="help-block">
                      <strong>{{ $errors->first('shopname') }}</strong>
                  </span>
               @endif
              </div>
             
            </div>

            <div class="form-group{{ $errors->has('barnumber') ? ' has-error' : '' }}">
             
              <label class="control-label col-md-5" for="barnumber"> Shop BAR Number</label>
              <div class="col-md-7">
                <input type="number" class="form-control" name="barnumber" placeholder="shop bar number" required/>
                 @if ($errors->has('barnumber'))
                  <span class="help-block">
                      <strong>{{ $errors->first('barnumber') }}</strong>
                  </span>
               @endif
              </div>
             
            </div>

            <div class="form-group{{ $errors->has('epanumber') ? ' has-error' : '' }}">
             
              <label class="control-label col-md-5" for="epanumber"> Shop EPA Number</label>
              <div class="col-md-7">
                <input type="number" class="form-control" name="epanumber" placeholder="shop epa number" required/>
                 @if ($errors->has('epanumber'))
                  <span class="help-block">
                      <strong>{{ $errors->first('epanumber') }}</strong>
                  </span>
               @endif
              </div>
             
            </div>

            <div class="form-group{{ $errors->has('phonenumber') ? ' has-error' : '' }}">
             
              <label class="control-label col-md-5" for="phonenumber"> Shop Phone Number</label>
              <div class="col-md-7">
                <input type="text" class="form-control" name="phonenumber" placeholder="shop phone number" required/>
                 @if ($errors->has('phonenumber'))
                  <span class="help-block">
                      <strong>{{ $errors->first('phonenumber') }}</strong>
                  </span>
                 @endif
              </div>
             
            </div>
            <div class="form-group text-center">
              <input type="submit" class="btn btn-primary">
            </div>
          
        </div>
        </form>
      
     </div>
  </div>
   <div class='modal fade' id='myModal1' role='dialog' data-keyboard='false' data-backdrop='static'>
    <div class='modal-dialog' role='document'>                             
      <div class='modal-content'>     
          <div class='modal-header'>
           <i class='fa fa-close' id="close" data-dismiss='modal' style='float:right;cursor:pointer;'></i>
          
          </div>       
          <div class='modal-body'>            
             Please select one plan !.
          </div>    
          <div class="modal-footer">                  
          </div>                             
      </div>
    </div>
  </div>
     
 
@endsection
@section('scripts')
<script type="text/javascript" src="{{asset('js/shopsignup.js')}}"></script>
@endsection