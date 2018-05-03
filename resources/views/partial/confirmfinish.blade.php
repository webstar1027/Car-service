@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/confirmfinish.css')}}">
@endsection
@section('content')
   <div class="container">
     <div class="col-md-12"> 
         <div class="text-center">
           <?php 
            $category = session()->get('category');
            $category_name = $category['category_name'];
            $parent_name = $category['parent_name'];
            session()->forget('year');
            session()->forget('make');
            session()->forget('model');
            session()->forget('term');
            session()->forget('category');
            session()->forget('costs');
            session()->forget('id_data');
            session()->forget('viewTermData');
           ?>
           <h4> Success Service Created!</h4>

         </div> 

         <div class="text-center">
            <a class="btn btn-primary" href="{{route('pagination')}}"> Exit  </a>
         </div>   

      
      </div>      
   </div>

  
@endsection