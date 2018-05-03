@extends('layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/shopblock.css')}}">
@endsection

@section('content')
<div class="container">
  <div class="col-md-12 part">    
	  	<legend style="text-align: center;">Edit Shop Block </legend>
	  	<input type="hidden" id="shop_id" value="{{$shop_id}}"/>

	  	<div class="row">
	  		<div class="form-group">
	  			<h4> Always Block:</h4>	  			
	  				<table class="table table-bordered">
	  					<thead>
	  						<tr>
	  							 <td>#</td>
	  							 <td>Description</td>
	  							 <td>Day</td>
	  							 <td>Start Time </td>
	  							 <td>End Time</td>
	  							 <td>Edit</td>
	  							 <td>Delete</td>
	  						</tr>
	  					</thead>
	  					<tbody>
	  						<?php $count = 1;
	  						  $total_number = count($shopblockschedule);
	  						?>
	  						@foreach($shopblockschedule as $item)
	  						  
		  						@if($item['block_type'] == 0)
		  							<tr>
			  							<td>{{$count}}</td>
			  							<td><input type="text" name="alwaysdescription{{$item['shopblockschedule_id']}}" class="form-control" value="{{$item['description']}}"/></td>
			  							<td>
			  								 <select class="form-control" id="alwaysdate{{$item['shopblockschedule_id']}}">
			  								 	 <?php 
			  								 	   switch ($item['block_date']) {
			  								 	   	case 'monday':
			  								 	   		$default = 'Every Monday';
			  								 	   		$value = 'monday';
			  								 	   		break;
			  								 	   	case 'tuesday':
			  								 	   		$default = 'Every Tuesday';
			  								 	   		$value = 'tuesday';
			  								 	   		break;
			  								 	   	case 'wednesday':
			  								 	   		$default = 'Every Wednesday';
			  								 	   		$value = 'wednesday';
			  								 	   		break;
			  								 	   	case 'thursday':
			  								 	   		$default = 'Every Thursday';
			  								 	   		$value = 'thursday';
			  								 	   		break;
			  								 	   	case 'friday':
			  								 	   		$default = 'Every Friday';
			  								 	   		$value = 'friday';
			  								 	   		break;
			  								 	   	case 'saturday':
			  								 	   		$default = 'Every Saturday';
			  								 	   		$value = 'saturday';
			  								 	   		break;
			  								 	   	case 'sunday':
			  								 	   		$default = 'Every Sunday';
			  								 	   		$value = 'sunday';
			  								 	   		break; 								 	   	
			  								 	 
			  								 	   }
			  								 	 ?>
			  								 	 <option selected value= {{$value}} hidden> {{$default}} </option>
			  								 	 <option value="monday"> Every Monday </option>
			  								 	 <option value="tuesday"> Every Tuesday </option>
			  								 	 <option value="wednesday"> Every Wednesday </option>
			  								 	 <option value="thursday"> Every Thursday </option>
			  								 	 <option value="friday"> Every Friday </option>
			  								 	 <option value="saturday"> Every Saturday </option>
			  								 	 <option value="sunday"> Every Sunday </option>
			  								 </select>
			  							</td>
			  							<td>
			  								<div class="input-group date" id="alwaysopentime{{$count}}"> 	          
						          	  <input type='text' name="alwaysstarttime{{$item['shopblockschedule_id']}}" value="{{$item['open_time']}}" class="form-control" value="" />
						              <span class="input-group-addon">
						                <span class="glyphicon glyphicon-time"></span>
						              </span>
					              </div>
			  							</td>
			  							<td>
			  								<div class="input-group date" id="alwaysclosetime{{$count}}"> 	          
						          	  <input type='text' name="alwaysendtime{{$item['shopblockschedule_id']}}" value="{{$item['close_time']}}" class="form-control" value="" />
						              <span class="input-group-addon">
						                <span class="glyphicon glyphicon-time"></span>
						              </span>
					              </div>
			  							</td>
			  							<td style="cursor: pointer;" class="always-update" id="alwaysupdate{{$item['shopblockschedule_id']}}"><i class="fa fa-save"></i> Save</td>
			  							<td style="cursor: pointer;" class="always-delete" id="alwaysdelete{{$item['shopblockschedule_id']}}"><i class="fa fa-trash"></i> Delete</td>
			  						</tr>
			  						<?php $count++;?> 
		  						@endif		 		  											
	  						@endforeach
	  					</tbody>
	  				</table>  			
	  		</div>
	    </div>
      <input type="hidden" value="{{$total_number}}" id="total_number"/>
	    <div class="row">
	  		<div class="form-group">
	  			<h4> One Time Block:</h4>	  			
	  				<table class="table table-bordered">
	  					<thead>
	  						<tr>
	  							 <td>#</td>
	  							 <td>Description</td>
	  							 <td>Day</td>
	  							 <td>Start Time </td>
	  							 <td>End Time</td>
	  							 <td>Edit</td>
	  							 <td>Delete</td>
	  						</tr>
	  					</thead>
	  					<tbody>
	  						<?php $count1 = 1;
	  						 
	  						?>
	  						@foreach($shopblockschedule as $item)
	  						  
		  						@if($item['block_type'] == 1)
		  							<tr>
			  							<td>{{$count1}}</td>
			  							<td><input type="text" name="onetimedescription{{$item['shopblockschedule_id']}}" class="form-control" value="{{$item['description']}}"/></td>
			  							<td>
			  								<div class='input-group date' id='onetimepicker{{$count1}}'>
					                <input type="text" name="onetimedate{{$item['shopblockschedule_id']}}" value="{{$item['block_date']}}" class="form-control" />
					                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
					                </span>
						            </div>
			  							</td>
			  							<td>
			  								<div class="input-group date" id="onetimeopentime{{$count1}}"> 	          
						          	  <input type='text' name="onetimestarttime{{$item['shopblockschedule_id']}}" value="{{$item['open_time']}}" class="form-control" value="" />
						              <span class="input-group-addon">
						                <span class="glyphicon glyphicon-time"></span>
						              </span>
					              </div>
			  							</td>
			  							<td>
			  								<div class="input-group date" id="onetimeclosetime{{$count1}}"> 	          
						          	  <input type='text' name="onetimeendtime{{$item['shopblockschedule_id']}}" value="{{$item['close_time']}}" class="form-control" value="" />
						              <span class="input-group-addon">
						                <span class="glyphicon glyphicon-time"></span>
						              </span>
					              </div>
			  							</td>
			  							<td style="cursor: pointer;" class="onetime-update" id="onetimeupdate{{$item['shopblockschedule_id']}}"><i class="fa fa-save"></i> Save</td>
			  							<td style="cursor: pointer;" class="onetime-delete" id="onetimedelete{{$item['shopblockschedule_id']}}"><i class="fa fa-trash"></i> Delete</td>
			  						</tr>
			  						<?php $count1++;?> 	
		  						@endif		 
		  										
	  						@endforeach
	  					</tbody>
	  				</table>	  			
	  		</div>
	    </div>


	    <!-- Add new always block time schedule -->
	    <div class="row">
	    	<h4> Add New Always Block Event </h4>
	    	<div class="col-md-3">
	    		<label> Description : </label> <input type="text" class="form-control" name="block_description" value="">
	    	</div>

	    	<div class="col-md-3">
	    		<label> Block Day: </label>	    	
	  		  <select class="form-control" id="alwaysblock">
	  		  	<option selected hidden></option>
	  		  	<option value="monday"> Every Monday </option>
	  		  	<option value="tuesday"> Every Tuesday </option>
	  		  	<option value="wednesday"> Every Wednesday </option>
	  		  	<option value="thursday"> Every Thursday </option>
	  		  	<option value="friday"> Every Friday </option>
	  		  	<option value="saturday"> Every Saturday </option>
	  		  	<option value="sunday"> Every Sunday </option>
	  		  </select>
	    	</div>

	    	<div class="col-md-2">
	    		<label> Start Time: </label>	    		
    			<div class="input-group date" id="alwaystimepicker1"> 	          
        	   <input type='text' name="always_start_time" class="form-control" value="" />
             <span class="input-group-addon">
               <span class="glyphicon glyphicon-time"></span>
             </span>
          </div>
	    	</div>

	    	<div class="col-md-2">
	    		<label> End Time: </label>	    		
    			<div class="input-group date" id="alwaystimepicker2"> 	          
        	   <input type='text' name="always_end_time" class="form-control" value="" />
             <span class="input-group-addon">
               <span class="glyphicon glyphicon-time"></span>
             </span>
          </div>
        </div>

        <div class="col-md-2">        
          <button  class="btn btn-primary" name="" style="margin-top:25px;" id="always_save">Save</button>
	    	</div>
	    </div>


	     <!-- Add new always block time schedule -->
	    <div class="row">
	    	<h4> Add New One Time Block Event </h4>
	    	<div class="col-md-3">
	    		<label> Description : </label> <input type="text" class="form-control" name="one_time_description" value="">
	    	</div>
	    	<div class="col-md-3">
	    		<label> Block Day: </label>	    	
	  			<div class="input-group date" id="onetimedatepicker"> 	          
	      	   <input type='text' name="onetime_open_date" class="form-control" value="" />
	           <span class="input-group-addon">
	             <span class="glyphicon glyphicon-calendar"></span>
	           </span>
	         </div>    	
	    	</div>

	    	<div class="col-md-2">
	    		<label> Start Time: </label>	    		
    			<div class="input-group date" id="onetimetimepicker1"> 	          
        	   <input type='text' name="onetime_open_time1" class="form-control" value="" />
             <span class="input-group-addon">
               <span class="glyphicon glyphicon-time"></span>
             </span>
          </div>
	    	</div>

	    	<div class="col-md-2">
	    		<label> End Time: </label>	    		
    			<div class="input-group date" id="onetimetimepicker2"> 	          
        	   <input type='text' name="onetime_open_time2" class="form-control" value="" />
             <span class="input-group-addon">
               <span class="glyphicon glyphicon-time"></span>
             </span>
          </div>
        </div>

        <div class="col-md-2">        
          <button  class="btn btn-primary" name="" id="one_time_save" style="margin-top:25px;">Save</button>
	    	</div>
	    </div>
	  
	</div>

	 <div class='modal fade' id='myModal' role='dialog' data-keyboard='false' data-backdrop='static'>
	  <div class='modal-dialog' role='document'>                             
	      <div class='modal-content'>     
	          <div class='modal-header'>
	           <i class='fa fa-close' data-dismiss='modal' style='float:right;cursor:pointer;'></i>
	           <h4 class="modal-title">Confirm Update of Always Block Time </h4>
	          </div>       
	          <div class='modal-body'>            
	             Would you update always block time?
	          </div>    
	          <div class="modal-footer">
	              <button type="button" class="btn btn-default always_confirm" data-dismiss="modal">Confirm</button>
	              <button type="button" class="btn btn-default cancel" data-dismiss="modal">Cancel</button>
	          </div>                             
	      </div>
	  </div>
	 </div>
	  <div class='modal fade' id='myModal1' role='dialog' data-keyboard='false' data-backdrop='static'>
	  <div class='modal-dialog' role='document'>                             
	      <div class='modal-content'>     
	          <div class='modal-header'>
	           <i class='fa fa-close' data-dismiss='modal' style='float:right;cursor:pointer;'></i>
	           <h4 class="modal-title">Confirm Delete of Always Block Time </h4>
	          </div>       
	          <div class='modal-body'>            
	             Would you delete always block time?
	          </div>    
	          <div class="modal-footer">
	              <button type="button" class="btn btn-default always_delete" data-dismiss="modal">Confirm</button>
	              <button type="button" class="btn btn-default cancel" data-dismiss="modal">Cancel</button>
	          </div>                             
	      </div>
	  </div>
	 </div>

	 <div class='modal fade' id='myModal2' role='dialog' data-keyboard='false' data-backdrop='static'>
	  <div class='modal-dialog' role='document'>                             
	      <div class='modal-content'>     
	          <div class='modal-header'>
	           <i class='fa fa-close' data-dismiss='modal' style='float:right;cursor:pointer;'></i>
	           <h4 class="modal-title">Confirm Update of One Block Time </h4>
	          </div>       
	          <div class='modal-body'>            
	             Would you update one time block?
	          </div>    
	          <div class="modal-footer">
	              <button type="button" class="btn btn-default onetime_confirm" data-dismiss="modal">Confirm</button>
	              <button type="button" class="btn btn-default cancel" data-dismiss="modal">Cancel</button>
	          </div>                             
	      </div>
	  </div>
	 </div>

	 <div class='modal fade' id='myModal3' role='dialog' data-keyboard='false' data-backdrop='static'>
	  <div class='modal-dialog' role='document'>                             
	      <div class='modal-content'>     
	          <div class='modal-header'>
	           <i class='fa fa-close' data-dismiss='modal' style='float:right;cursor:pointer;'></i>
	           <h4 class="modal-title">Confirm Delete of One Block Time </h4>
	          </div>       
	          <div class='modal-body'>            
	             Would you delete one time block?
	          </div>    
	          <div class="modal-footer">
	              <button type="button" class="btn btn-default onetime_delete" data-dismiss="modal">Confirm</button>
	              <button type="button" class="btn btn-default cancel" data-dismiss="modal">Cancel</button>
	          </div>                             
	      </div>
	  </div>
	 </div>
</div>
@endsection

@section('scripts')
<script src="{!! URL::asset('lib/bootstrap-datetimepicker/js/moment.js') !!}"></script>
<script src="{!! URL::asset('lib/bootstrapvalidator/dist/js/bootstrapValidator.min.js') !!}"></script>
<script src="{!! URL::asset('lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') !!}"></script>
<script type="text/javascript" src="{{asset('js/shopblock.js')}}"></script>
@endsection