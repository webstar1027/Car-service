<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Car Service') }}</title>
     
   
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Faster+One" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/remodal.css')}}">
    <link rel="stylesheet" href="{{asset('css/remodal-default-theme.css')}}">  
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" >      
    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('lib/bootstrap/dist/css/bootstrap.min.css')}}">
    <link  rel="stylesheet" href="{{asset('lib/font-awesome-4.7.0/css/font-awesome.min.css')}}">   
    <link rel="stylesheet" href="{!! asset('lib/bootstrapvalidator/dist/css/bootstrapValidator.min.css')!!}"/>
    <link rel="stylesheet" href="{!! URL::asset('lib/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">  
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.foundation.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.jqueryui.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.semanticui.min.css">

     @yield('css')
     <!-- jQuery library -->      
   
    <style>
      body{
        background-color:#dfe2db;
        min-width: 300px;
      }    
    .navbar-default .navbar-nav>li>a {
      color: #fff;
     }
     .navbar-default .navbar-nav>li>a:hover {
      color: black;
      background-color: #dfe2db;
     
     }
     .navbar-default .navbar-nav>.active>a, .navbar-default .navbar-nav>.active>a:focus, .navbar-default .navbar-nav>.active>a:hover {
        color: #20820f;
        background-color: #dfe2db;
     
        font-weight: 300;
       
      }
       .nav .credential a{
        color: #636b6f;      
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
        border-radius: 4px;
        border:1px solid white;
        padding-top:8px;
        padding-left: 30px;
        padding-right:30px;
        padding-bottom: 8px;
        color: #636b6f;
        font-family: 'Raleway', sans-serif;
        font-weight: 100;
        margin-top:5px;
   
      }
      .navbar-brand{
        color:white;
        font-weight: 700;
        font-size: 38px;
        font-family:'Rosewood Std Regular'; 
     
        position:absolute;
        top:1%;
        left:12%;
      }
      .navbar-nav {
          margin: 0px -15px;
      }
    @media (min-width: 768px) and (max-width: 1200px) {
      .container-fluid{
        padding-right: 0;
        padding-left: 0;
      }
      .navbar-header {
          float: none;
      }
      .navbar-left,.navbar-right {
          float: none !important;
      }
      .navbar-toggle {
          display: block;
          margin-left: 10px;
      }
      .navbar-collapse {
          border-top: 1px solid transparent;
          box-shadow: inset 0 1px 0 rgba(255,255,255,0.1);
      }
      .navbar-fixed-top {
          top: 0;
          border-width: 0 0 0 1px;
      }
      .navbar-collapse.collapse {
          display: none!important;
      }
      .navbar-nav {
          float: none!important;
         
      }
      .navbar-nav>li {
          float: none;
      }
      .navbar-nav>li>a {
          padding-top: 10px;
          padding-bottom: 10px;
      }
      .collapse.in{
          display:block !important;
      }
      .navbar-brand {
        color: #ffffff;
        font-weight: 700;
        font-size: 38px;
        font-family: 'Rosewood Std Regular';
        padding-top: 20px;
        position: absolute;
        top: 1%;
        left: 2%;
      }
    

    }
    @media only screen and (max-width:768px){
     .navbar-collapse.in {
           overflow-y: hidden; 
     }
 
    }
 
    </style>
     
</head>
<body>
    <!-- Global Scripts -->    
    <script src="{!! URL::asset('js/jquery.min.js')!!}"></script>       
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCrVui1Yeur4NfiHuGWTSuFs1KBd9u8Jg4&libraries=places"></script>
    <script src="{!! URL::asset('js/jquery.googlemap.js') !!}"></script>  
    <script src="{!! URL::asset('js/remodal.js') !!}"></script>    

    <!-- Custom Scripts -->
    <script src="{!! URL::asset('js/app.js') !!}"></script> 
    @yield('scripts')  
    <div id="app">    
        <nav class="navbar navbar-default navbar-static-top" style="background-color: #272727; margin-bottom: 0;">
            <div class="container" id="contain">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}" style="color:white;font-family: 'Faster One', cursive;">
                        {{ config('app.name', 'Car Sevice') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>                
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())

                            <li class="credential" ><a href="{{ route('login') }}" style="color:#ffffff; font-weight: 300;">Sign In</a></li>
                            <li class="credential"><a href="{{ route('register') }}" style="color:#ffffff; font-weight: 300;">Sign Up</a></li>
                        @else
                            <?php                                  
                                $user_id = Auth::user()->id;
                                $role_id = App\Model\RoleUser::where('user_id', $user_id)->first()->role_id;
                                $role_name = App\Model\Role::where('id', $role_id)->first()->role_name;
                            ?>
                            @if($role_name == 'user')
                             <li class="{{Request::is('user') ? 'active':''}}"><a href="{{url('/user')}}"> Search For Service </a></li>
                             <li class="{{Request::is('mycar') ? 'active':''}}"><a href="{{url('/mycar')}}"> My Cars </a></li>
                             <li class="{{Request::is('schedule') ? 'active':''}}"><a href="{{url('/schedule')}}"> My Scheduled Service </a></li>
                             <li class="{{Request::is('rate') ? 'active':''}}"><a href="{{url('/rate')}}"> Rate Service Experience </a></li>
                             <li class="{{Request::is('myprofile') ? 'active':''}}"><a href="{{url('/myprofile')}}"> My Profile </a></li>
                            @elseif($role_name == 'shopowner')
                             <li class="{{Request::is('shopowner') ? 'active':''}}"><a href="{{url('/shopowner')}}"> My Services </a></li>
                             <li class="{{Request::is('shop/schedule') ? 'active':''}}"><a href="{{url('/shop/schedule')}}"> My Schedule </a></li>
                             <li class="{{Request::is('shop/subscription') ? 'active':''}}"><a href="{{url('/shop/subscription')}}">My Subscription</a></li>
                             <li class="{{Request::is('shop/profile') ? 'active':''}}"><a href="{{url('/shop/profile')}}"> My Profile </a></li>
                            @elseif($role_name == 'master')
                             <li class="{{Request::is('admin/operator') ? 'active':''}}"><a href="{{url('/admin/operator')}}"> Operator </a></li>
                            @endif
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="color:#ffffff; font-weight: 700; border:none;">
                                    {{ Auth::user()->username }} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                  <li>
                                      <a href="{{ route('logout') }}"
                                          onclick="event.preventDefault();
                                                   document.getElementById('logout-form').submit();">
                                          Logout
                                      </a>

                                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                          {{ csrf_field() }}
                                      </form>
                                  </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        @yield('content')      

    </div>       
   
  <script>
   $(window).resize(function(){
    $(document).ready(function(){
       if($(window).width() <= 1200) {
         $('#contain').removeClass();
         $('#contain').addClass('container-fluid');
         console.log($(window).width());
       }
       else{
           $('#contain').removeClass();
         $('#contain').addClass('container');
       }
    });
   });
    $(document).ready(function(){
       if($(window).width() <= 1200) {
         $('#contain').removeClass();
         $('#contain').addClass('container-fluid');
         console.log($(window).width());
       }
       else{
         $('#contain').removeClass();
         $('#contain').addClass('container');
       }
         
    });

 
 
  </script>
</body>
</html>
