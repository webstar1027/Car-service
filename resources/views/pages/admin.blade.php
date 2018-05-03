@extends('layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/admin.css')}}">
@endsection

@section('scripts')
<script type="text/javascript" src="{{asset('js/admin.js')}}"></script>

@endsection
@section('content')
<div class="container">
   <div class="col-md-12">
   		<div class="panel panel-primary">
   			<div class="panel-heading">   				
   				  <h4> <i class="fa fa-edit"></i> Car information</h4>   				
   			</div>
   			<div class="panel-body">
   				<div class="btn-group">
	   			 			<button class="btn btn-success" id="car-new"> Add New <i class="fa fa-plus"></i></button>
	   			</div>
 			 		</br>
 			 		</br>
 			 		<?php $count = 1; ?>
	   			<table class="table table-inverse table-bordered" id="car-body"> 
	   			 <thead>
	   			 	<tr>
	   			 	  <td>No</td>
	   			 	  <td>Make</td>
	   			 	  <td>Year</td>
	   			 	  <td>Model</td>
	   			 	  <td>Term</td>
	   			 	  <td>Cylinder</td>
	   			 	  <td>Edit</td>
	   			 	  <td>Delete</td>
	   			 	</tr>
	   			 </thead>
	   			 <tbody >				
	   			 		
	   			 		@foreach($cars as $car)
	   			 		  
	   			 			<tr id="{{$car->id}}">	
	   			 			  <td id="number{{$car->id}}"> {{$count++}}</td>
			   			 	  <td id="make{{$car->id}}">{{$car->make}}</td>
			   			 	  <td id="year{{$car->id}}">{{$car->year}}</td>
			   			 	  <td id="model{{$car->id}}">{{$car->model}}</td>
			   			 	  <td id="term{{$car->id}}">{{$car->term}}</td>
			   			 	  <td id="cylinder{{$car->id}}">{{$car->cylinder}}</td>
						 	  	<td class="edit" id="{{$car->id}}"><i class="fa fa-edit"></i>eidt</td>
						 	  	<td class="delete" id="{{$car->id}}">						 	  			
						 	  			<i class="fa fa-trash"></i>delete
						 	  	</td>
						 	 	</tr>						 	 
						 @endforeach	
						 	  <tr class="car-insert">
						 	  </tr>	   			 	 
	   			 </tbody>
	   			</table>
   		</div>
   	</div>
    <div class="panel panel-primary">
   			<div class="panel-heading">   				
   				  <h4> <i class="fa fa-edit"></i> Category Edit</h4>   				
   			</div>
   			<div class="panel-body">  				 
   			 		
	   				<div class="form-group">	   			 		
	   			 		<button class="btn btn-success  category-select"> Add New <i class="fa fa-hand-pointer-o" aria-hidden="true"></i></button>
	   			 	</div>   			 	
   			 			<!-- category name input -->		   			 		
		   			 <div id="category_select" style="display: none;">
	   			 		<div class="form-group">
		   			 		 <label class="control-label">Category:</label>
		   			 		 <input class="form-control" list="category_name" name="main_category">
					       <datalist id="category_name">					       
					       @foreach($categorys as $category)
					        <option value="{{$category}}"></option>							       
					       @endforeach
					      </datalist>
	   			 		</div>

	   			 		<div class="form-group">
		   			 		 <label class="control-label"> Sub-category:</label>
		   			 		 <input class="form-control" list="subcategory_name" name="sub_category">
		   			 		 <datalist id="subcategory_name">			      
					       </datalist>
	   			 		</div>

	   			 		<div class="form-group">
		   			 		<label class="control-label"> Sub-Sub-Category:</label>
		   			 		<input class="form-control" list="sub2category_name" name="sub2_category">
		   			 		<datalist id="sub2category_name">			      
					      </datalist>
		   			 	
	   			 		</div>

	   			 		<div class="form-group">
		   			 		<label class="control-label"> Sub-Sub-Category:</label>
		   			 		<input class="form-control" list="sub3category_name" name="sub3_category">
		   			 		<datalist id="sub3category_name">			      
					      </datalist>
	   			 		</div>

	   			 		<div class="form-group">
		   			 		<label class="control-label"> Sub-Sub-Sub-Category:</label>
		   			 		<input class="form-control" list="sub4category_name" name="sub4_category">
		   			 	 	<datalist id="sub4category_name">		      
					      </datalist>
	   			 		</div>	  			 	
	   			 		<div class="form-group">
			   			 		<label class="control-label"> QTY</label>
			   			 		<input class="form-control form-control-solid placeholder-no-fix" type="text" placeholder="Please input necessary quanity number" id="QTY_select">
		   			 	</div>	   			
	   			 		<div class="form-group">
	   			 			<button class="col-md-offset-5 btn btn-primary select-save">Save <i class="fa fa-save"></i></button>
	   			 		</div>		   			 		   			 
		   			 </div>	   
		   			
		   		</br>
		   		</br>
		   		<div class="serviceofcar" style="margin-top:30px;">
		   			<table class="table table-inverse table-bordered" id="category-body"> 
		   			 <thead>
		   			 	<tr>
		   			 	  <td>No</td>		   			 	 
		   			 	  <td>Category Name</td>
		   			 	  <td>Parent id</td>
		   			 	  <td>Level</td>
		   			 	  <td>QTY</td>
		   			 	  <td>Edit</td>
		   			 	  <td>Delete</td>
		   			 	</tr>
		   			 </thead>
		   			 <tbody>	   			 		
	   			 		<?php $count_service = 1; ?>
	   			 		@foreach($services as $item)
	   			 			<tr id="{{$item->id}}">
		   			 		  <td id="number{{$item->id}}">{{$count_service ++}}</td>		   			 		 
		   			 		  <td id="name{{$item->id}}">{{$item->category_name}}</td>
			   			 	  <td id="parent_id{{$item->id}}">{{$item->parent_id}}</td>
			   			 	  <td id="level{{$item->id}}">{{$item->level}}</td>
			   			 	  <td id="QTY{{$item->id}}">{{$item->QTY}}</td>			   			 	
						 	  	<td class="category-edit" id="{{$item->id}}" style="cursor: pointer;"><i class="fa fa-edit"></i>eidt</td>
						 	  	<td class="category-delete" id="{{$item->id}}" style="cursor: pointer;"><i class="fa fa-trash"></i>delete</td>
						 	 	</tr>
						 	@endforeach		   			 	 
		   			 </tbody>
		   			</table>
		   		</div>	   		
			</div>
		</div>
		<div class="panel panel-primary">
   			<div class="panel-heading">   				
   				  <h4> <i class="fa fa-edit"></i> Shop information</h4>   				
   			</div>
   			<div class="panel-body">	   			
	   				<div class="form-group">
	   			 		<button class="btn btn-success  shop-new"> Add New <i class="fa fa-plus"></i></button>	   			 		
	   			 	</div>
	   			 	<table class="table table-inverse table-bordered" id="shop-body"> 
			   			 <thead>
			   			 	<tr>
			   			 	  <td>No</td>		   			 	 
			   			 	  <td>Shop Name</td>		   			 	
			   			 	  <td>Zip_code</td>
			   			 	  <td>Shop Phone number</td>
			   			 	  <td>BAR number</td>
			   			 	  <td>EPA number</td>		   			 	 
			   			 	  <td>Edit</td>
			   			 	  <td>Delete</td>
			   			 	</tr>
			   			 </thead>
			   			 <tbody>	   			 		
		   			 		<?php $count_shop = 1; ?>
		   			 		@foreach($shops as $item)
		   			 			<tr id="{{$item->id}}">
			   			 		  <td id="number{{$item->id}}">{{$count_shop ++}}</td>		   			 		 
			   			 		  <td id="shop_name{{$item->id}}">{{$item->shop_name}}</td>
				   			 	  <td id="zip_code{{$item->id}}">{{$item->zip_code}}</td>
				   			 	  <td id="phonenumber{{$item->id}}">{{$item->shop_phonenumber}}</td>
				   			 	  <td id="BARnumber{{$item->id}}">{{$item->BAR_number}}</td>
				   			 	  <td id="EPAnumber{{$item->id}}">{{$item->EPA_number}}</td>			   			 	
							 	  <td class="shop-edit" id="{{$item->id}}" style="cursor: pointer;"><i class="fa fa-edit"></i>eidt</td>
							 	  <td class="shop-delete" id="{{$item->id}}" style="cursor: pointer;"><i class="fa fa-trash"></i>delete</td>
							 	 </tr>
							 @endforeach		
							    <tr class="shop-insert">
							    </tr>   			 	 
			   			 </tbody>
		   			</table>
				</div>
   	</div>   
  </div>
  <div class="loader" style="display:none;">
  </div>
</div>
@endsection