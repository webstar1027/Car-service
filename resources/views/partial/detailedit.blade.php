@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/detailedit.css')}}">
@endsection
@section('scripts')
<script type="text/javascript" src="{{asset('js/detailedit.js')}}"></script>
@endsection
@section('content')
   <div class="container">
     <div class="col-md-12">        
       <div class="panel panel-primary">
          <div class="panel-heading">           
              <h4> <i class="fa fa-edit" aria-hidden="true"></i> Price Edit </h4>           
          </div>
          <div class="panel-body">
              <!-- this part is for category selection -->
              <div class="col-md-10 col-md-offset-1 category-select-part">
                  <div class="text-center">
                     <h4> Service Name ( {{$category['category_name']}})</h4>
                  </div>
              </div>
                 <!-- service input part -->
               <div class="col-md-10 col-md-offset-1 category-select-part"  style="margin-top:30px; margin-bottom: 60px;">
                 
                 <div class="form-group">
                   <h5> Master service Name :</h5>
                   <textarea class="form-control" id="masterservice_name"></textarea>
                 </div>
                 <div class="form-group">
                   <h5> Service description for all child services :</h5>
                   <textarea class="form-control" id="service_description"></textarea>                   
                 </div>        
                
                 <div class="form-group">
                   <h5> Minutes to complete each of child services : </h5>
                   <select class="form-control" id="complete_time">
                     <option selected hidden></option>
                     @for($i=30; $i<=180; $i+=30)
                       <option value="{{$i}}">{{$i}} minutes</option>
                     @endfor
                   </select>
                 </div>   
                 <div class="text-center">
                    <button class="btn btn-primary" id="service_edit">Apply </button>
                 </div>             
               </div>
               <!-- this part is for price selection -->
               <div class="col-md-10 col-md-offset-1 category-select-part">
                 <div class="form-group">     
                  <h4><i class="fa fa-edit" aria-hidden="true"></i> Default Values</h4>               
                 </div>
                 
                 <div class="table-responsive">
                    <table class="table table-inverse table-bordered"  id="default_part" style="margin-top:30px;">
                       <thead>
                        <tr>
                          <td>Line item</td>
                          <td>Description</td>
                          <td>Type</td>
                          <td>Price</td>
                          <td>Apply</td>
                         </tr>
                       </thead> 
                       <tbody>
                         @if($category['item_number'] == 1)
                           <tr id="1">
                             <td>1</td>
                             <td><input type="text" class="form-control" value="{{$category['description']}}" id="item_description1"></td>
                             <td>Call for Price</td>
                             <td><input type="text" class="form-control" value="{{$category['price']}}" id="item_price1"></td>
                             <td class="apply" id="apply1" style="font-size: 13px;">Apply</td>
                           </tr>
                         @else
                            @for($i = 0; $i< $category['item_number']; $i++)
                             <tr id="{{$i+1}}">
                                <td>{{$i+1}}</td>
                                <td><input type="text" class="form-control" value="{{$category['description'][$i]}}" id="item_description{{$i+1}}"></td>
                                <td>
                                  <select class="form-control" id="item_type{{$i+1}}">
                                    <option selected value="{{$category['item_type'][$i]}}">{{$category['item_type'][$i]}}</option>
                                    @foreach($category['price_type'] as $item)
                                    <option value="{{$item}}">{{$item}}</option>
                                    @endforeach
                                  </select>
                                </td>
                                <td><input type="text" class="form-control" value="{{$category['price'][$i]}}" id="item_price{{$i+1}}"></td>
                                <td class="apply" id="apply{{$i+1}}" style="font-size: 13px;">Apply</td>
                              </tr>
                            @endfor   
                         @endif                
                       </tbody>
                     </table>
                 </div>
               </div>

            
               <!-- Service Schedualing Option -->
               <div class="col-md-10 col-md-offset-1 category-select-part">
                 <div class="form-group">     
                  <h4><i class="fa fa-edit" aria-hidden="true"></i> Service Schedualing Option</h4>               
                 </div>
                 <input type="hidden" name="plan" value="{{$plan['subscription_plan']}}">
                 <div class="form-group">
                   <select class="form-control" id="service_schedule">
                     <option selected hidden></option>                    
                   </select>
                 </div>
                 <div class="form-group text-center">
                   <button class="btn btn-primary" id="schedul_apply">Apply</button>
                 </div>
               </div>
              <!-- service register result -->
              <div class="col-md-12 table-responsive">
              <input type="hidden" name="item_number" value="{{$category['item_number']}}">
              <table class="table table-inverse table-bordered" id="service_body" style="margin-top:30px;"> 
                 <thead>
                  <tr>
                    <td>No</td>                
                    <td>Year</td>
                    <td>Make</td>
                    <td>Model</td>
                    <td>Term</td>
                    <td>Lowest level Service Name</td>
                    <td>Minutes to complete Service</td>
                    @for($i = 0; $i< $category['item_number']; $i++)                       
                     <td> Item{{$i+1}}</td>
                    @endfor   
                    <td>Total Service Price</td>                    
                    <td>Service Schedualing Option </td>  
                    <td>Description</td> 
                    <td>Edit</td>
                    <td>Save</td>
                  </tr>
                 </thead>
                 <tbody> 
                    <?php $count = 1 ;?>    
                    @foreach($cars as $item)
                     <tr id="{{$count}}">
                       <td>{{$count}}</td>
                       <td>{{$item['year']}}</td>
                       <td>{{$item['make']}}</td>
                       <td>{{$item['model']}}</td>
                       <td>{{$item['term']}}</td>
                       <td>{{$category['category_name']}}</td> 
                       <td class="complete_time"></td>
                        @for($i = 0; $i< $category['item_number']; $i++)                       
                         <td class="{{$i+1}}"></td>
                        @endfor
                       <td class="total"></td>
                       <td class="scheduale"></td>
                       <td class="description"></td>
                       <td class="edit" id="edit{{$count}}" style="cursor: pointer;"> <i class="fa fa-edit" style="pointer-events: none;"></i> Edit</td>
                       <td class="save" id="save{{$count}}" style="cursor: pointer;"><i class="fa fa-save" style="pointer-events: none;"></i> Save</td>
                     </tr>
                     <?php $count++;?> 
                     @endforeach                 
                </tbody>
             </table>
           </div>
             <div class="col-md-12 text-center" style="margin-top:30px;">
              <a class="btn btn-primary" id="multiservice_create"> Next <i class="fa fa-save"></i></a>
             </div>
          </div>
       </div>
      </div>  
      <div class="text-center" style="margin-bottom: 30px;">
        <span class="rating"></span>&nbsp<span id="text-inform">Note: Click next to confirm the new child service(s) that will be created.</span>
      </div>        
   </div>

   <div class="remodal" data-remodal-id="modal" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
    <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
      <div>
        <h2 id="modal1Title">Warning</h2>
        <p id="modal1Desc">
           You must select one year at least !
        </p>
      </div>
    <br>
    <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
    <button data-remodal-action="confirm" class="remodal-confirm">OK</button>
  </div>   

  <div class='modal fade' id='myModal' role='dialog' data-keyboard='false' data-backdrop='static'>
    <div class='modal-dialog' role='document'>                             
      <div class='modal-content'>     
          <div class='modal-header'>
           <i class='fa fa-close' id="close" data-dismiss='modal' style='float:right;cursor:pointer;'></i>
          
          </div>       
          <div class='modal-body'>            
             You must select one service scheduling option.
          </div>    
          <div class="modal-footer">                  
          </div>                             
      </div>
    </div>
</div>
@endsection