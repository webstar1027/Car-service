@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/category.css')}}">
<link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/ui-darkness/jquery-ui.min.css" rel="stylesheet">
@endsection
@section('scripts')
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="{{asset('js/category.js')}}"></script>

@endsection
@section('content')   
   <div class="container">
     <div class="col-md-12">        
       <div class="panel panel-primary">
          <div class="panel-heading">           
              <h4> <i class="fa fa-hand-pointer-o" aria-hidden="true"></i> Service Selection </h4>           
          </div>
          <div class="panel-body">
              <!-- this part is for category selection -->
              <div class="col-md-10 col-md-offset-1 category-select-part">
                  <div class="form-group">                      
                     <h4>Category Selection <i class="fa fa-hand-pointer-o" aria-hidden="true"></i></h4>
                  </div>                      
                  <div id="category_select" style="margin-top: -20px;">
                    <div class="form-group">
                       </br>
                       </br>
                       <label for="sel1">Category:</label>                     
                         <select class="form-control dropdown" id="category_name">
                           <option selected hidden>please input main category</option>               
                           @foreach($categorys as $category)
                            <option value="{{$category}}">{{$category}}</option>                     
                           @endforeach
                         </select>
                    </div>  
                    <div class="form-group" id = "sub-category">
                    </div>
                    <div class="form-group" id = "sub2-category">
                    </div>
                    <div class="form-group" id = "sub3-category">
                    </div>
                    <div class="form-group" id = "sub4-category">
                    </div>    
                  </div>      
              </div>

               <!-- this part is for price selection -->
               <div class="col-md-10 col-md-offset-1 category-select-part" style="margin-top:30px;">
                 <div class="form-group">     
                  <h4>Service Pricing Mode <i class="fa fa-hand-pointer-o" aria-hidden="true"></i></h4>               
                 </div> 
                 <!-- dropdown template for price selection -->

                 <div class="form-group">
                   <select class="form-control dropdown-content" id="price_option">
                     <option selected hidden>please select price type</option> 
                     <option value="Call for Price"> Call for Price</option>
                     <option value="Combined Price for parts and labor"> Combined Price for parts and labor </option>
                     <option value="Seperate Price for parts and labor">Seperate Price for parts and labor </option>
                   </select>
                 </div>
                 <div class="priceitem-edit" style="display: none;">
                   <div class="table-responsive">
                       <table class="table table-inverse table-bordered" id="item_table">
                         <thead>  
                           <tr>
                             <td>Description</td>
                             <td>Type</td>
                             <td>Price</td>
                           </tr>                     
                         </thead>
                         <tbody id="item_input">                       
                         </tbody>
                       </table>
                   </div>
                 </div>
                         
              </div>
              <div class="col-md-3 col-md-offset-5">
                <button class="btn btn-primary" style="margin-top:30px;" id="year_selection"> Next <i class="fa fa-hand-pointer-o" aria-hidden="true"></i></button>
              </div>
          </div>
       </div>
      </div>
      <div class="text-center" style="margin-bottom: 30px;">
        <span class="rating"></span>&nbsp<span id="text-inform">Note: Click next to select year of vehicle(s).</span>
      </div>         
   </div>

   <div class="remodal" data-remodal-id="modal" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
    <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
      <div>
        <h2 id="modal1Title">Warning</h2>
        <p id="modal1Desc">
           You must select category !
        </p>
      </div>
    <br>
    <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
    <button data-remodal-action="confirm" class="remodal-confirm">OK</button>
  </div>
  <div class="remodal" data-remodal-id="modal2" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
    <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
      <div>
        <h2 id="modal1Title">Warning</h2>
        <p id="modal1Desc">
           Please select one line item that is type price and other that is type part !
        </p>
      </div>
    <br>
    <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
    <button data-remodal-action="confirm" class="remodal-confirm">OK</button>
  </div>
   <div class="remodal" data-remodal-id="modal1" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
    <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
      <div>
        <h2 id="modal1Title">Warning</h2>
        <p id="modal1Desc">
           You can select maximum 10 numbers !
        </p>
      </div>
    <br>
    <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
    <button data-remodal-action="confirm" class="remodal-confirm">OK</button>
  </div>
  
    <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content" style="text-align: center;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">How many line items you need for this service pricing?</h4>
        </div>
        <div class="modal-body">
          <p>Please input number of line items for pricing!</p>
          <div class="form-group" style="display: flex;padding-left: 28%;">
            <span> number: &nbsp</span>
            <input type="text" class="form-control" id="item_number" style="width: 30%;">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default number_save" data-dismiss="modal">Save</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>
  
   
 
@endsection