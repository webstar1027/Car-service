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
         <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
         <link  rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
         <script src="{!! URL::asset('js/jquery.min.js')!!}"></script>   
         <script src="{!! URL::asset('lib/bootstrap/dist/js/bootstrap.min.js') !!}"></script>
        <!-- Styles -->
        <style>
            html, body {
              min-width: 300px;
              background-color: #dfe2db;           
             
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
             .content img{
                filter: grayscale(100%);
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
                padding-bottom: 6px;
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
        <nav class="navbar navbar-default navbar-static-top" style="background-color: #272727; margin-bottom: 0;border-bottom-width: 0px;">
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
                
                   <li> <a href="javascript:;" id="service" style="color:#ffffff; font-weight: 700;">Search Services</a></li>
                   <li> <a href="{{ url('/shop_owner') }}" style="color:#ffffff; font-weight: 700;">Shop Owners</a></li>               
                   <li> <a href="{{ url('/login') }}" style="color:#ffffff; font-weight: 700;">Sign In</a></li>
                   <li> <a href="{{ url('/register') }}" style="color:#ffffff; font-weight: 700;">Sign Up</a></li>                    
               
              </ul>                              
            </div>
          </div>
        </nav>       
        <div class="content">
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
              <!-- Indicators -->
              <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
                <li data-target="#myCarousel" data-slide-to="3"></li>
              </ol>

              <!-- Wrapper for slides -->
              <div class="carousel-inner">
                <div class="item active">
                  <img src="{{asset('images/service1.png')}}" class="img-responsive" alt="Los Angeles">
                </div>

                <div class="item">
                  <img src="{{asset('images/service2.jpg')}}" class="img-responsive" alt="Chicago">
                </div>

                <div class="item">
                  <img src="{{asset('images/service3.png')}}" class="img-responsive" alt="New York">
                </div>
                <div class="item">
                  <img src="{{asset('images/service4.png')}}" class="img-responsive" alt="New York">
                </div>
              </div>

              <!-- Left and right controls -->
              <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
        </div>
     <div class='modal fade' id='myModal' role='dialog' data-keyboard='false' data-backdrop='static'>
      <div class='modal-dialog' role='document'>                             
          <div class='modal-content'>     
              <div class='modal-header'>
               <i class='fa fa-close' data-dismiss='modal' style='float:right;cursor:pointer;'></i>
               <h4 class="modal-title">Confirm Login Maintfy </h4>
              </div>       
              <div class='modal-body'>            
                 You can search service after log in Maintfy.!
              </div>    
              <div class="modal-footer">
                  <button type="button" class="btn btn-default always_confirm" data-dismiss="modal">Confirm</button>
                  <button type="button" class="btn btn-default cancel" data-dismiss="modal">Cancel</button>
              </div>                             
          </div>
      </div>
     </div>
</div>

 <script>
  $(document).ready(function(){
     $('#service').click(function(){
        $('#myModal').modal('show');
     });
     if($(window).width() <= 990) {
       $('#contain').removeClass();
       $('#contain').addClass('container-fluid');
    
     }
     else{
       $('#contain').removeClass();
       $('#contain').addClass('container');
     }
  });

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
</script> 
    </body>    
</html>
