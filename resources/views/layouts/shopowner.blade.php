<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Maintfy</title>

        <!-- Fonts -->
         <link href="https://fonts.googleapis.com/css?family=Faster+One" rel="stylesheet">
         <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
         <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
         <link href="https://fonts.googleapis.com/css?family=Roboto:300|Rokkitt:300" rel="stylesheet">
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
         @yield('styles')
         <script src="{!! URL::asset('js/jquery.min.js')!!}"></script>   
         <script src="{!! URL::asset('lib/bootstrap/dist/js/bootstrap.min.js') !!}"></script>
        <!-- Styles -->
        <style>

            html, body {
                background-color: #dfe2db;         
                min-width: 300px;  
             
            }
            .navbar-right li > a{
                color: #636b6f;             
                font-size: 12px;
                font-weight: 600;              
                text-decoration: none;
                text-transform: uppercase;
                border-radius: 4px;
                border:1px solid white;                
                padding-top: 8px;
                padding-left: 30px;
                padding-right: 30px;
                padding-bottom: 8px;
                margin-top: 8px;
                font-family: 'Raleway', sans-serif;
            } 
            
            ul > li {
              margin-left:8px;
            }
            #myModal{
              margin-top: 150px;
            }
            #myModal .modal-body{
                text-align: center;
            }
            .content p{
              padding-top: 50px;
              font-size: 28px;            
              color:black;              
              font-family: 'Roboto', sans-serif;
              font-family: 'Rokkitt', serif;
            }
           @media (min-width: 768px) and (max-width: 990px) {
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
            ul > li {
              padding-right:25px;
            }

          }
          @media only screen and (max-width:768px){
             .navbar-collapse.in {
                   overflow-y: hidden; 
             }
             ul > li {
              padding-right:20px;
             }
          }
        </style>
    </head>
    <body>
      <div id="app">
        <nav class="navbar navbar-default navbar-static-top" style="background-color: #272727;">
          <div class="container" id="contain">
            <div class="navbar-header">          
               <!-- Collapsed Hamburger -->
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                  <span class="sr-only">Toggle Navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>   
              <a class="navbar-brand" style="color:#ffffff; font-weight: 700; font-size: 38px;font-family: 'Faster One', cursive;">
                        {{ config('app.name', 'Car Sevice') }}
              </a>
            </div>        
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
               <!-- Left Side Of Navbar -->
              <ul class="nav navbar-nav">
                  &nbsp;
              </ul>       
              <ul class="nav navbar-nav navbar-right">          
                <li><a href="{{url('/subscription')}}" style="color:#ffffff;">Maintfy Subscriptions</a></li>
                <li><a href="{{url('/shopsignup')}}" style="color:#ffffff;">Shop Sign Up</a></li>               
                <li><a href="{{url('/shopowner/login')}}" style="color:#ffffff;">Shop Admin Sign In</a></li> 
              </ul>                              
            </div>
          </div>
        </nav>        
              
        <div class="content">         
          @yield('content')   
        </div>   
     </div>
     @yield('scripts')
      <script>
       $(window).resize(function(){
        $(document).ready(function(){
           if($(window).width() <= 990) {
             $('#contain').removeClass();
             $('#contain').addClass('container-fluid');
            
           }
           else{
               $('#contain').removeClass();
             $('#contain').addClass('container');
           }
        });
       });
        $(document).ready(function(){
           if($(window).width() <= 990) {
             $('#contain').removeClass();
             $('#contain').addClass('container-fluid');
          
           }
           else{
             $('#contain').removeClass();
             $('#contain').addClass('container');
           }
             
        }); 
     </script>
    </body>    
</html>
