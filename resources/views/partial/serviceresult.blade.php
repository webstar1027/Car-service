
  <table class="table table-inverse table-bordered" id="service_body"> 
     <thead>
      <tr>
        <td>No</td>              
        <td>Service Name</td>
        <td>Year</td>
        <td>Make</td>
        <td>Model</td>
        <td>Term</td>
        <td>Cylinder</td>
        <td>Price</td>
        <td>Descriptions</td>
        <td>Edit</td>
        <td>Delete</td>
      </tr>
     </thead>
     <tbody>              
      <?php $count_service = 1; ?>
      @foreach($services as $item)
        <tr id="{{$item->serviceofshop_id}}">
          <td id="number{{$item->serviceofshop_id}}">{{$count_service ++}}</td>                
          <td id="name{{$item->serviceofshop_id}}">{{$item->category_name}}</td>
          <td id="year{{$item->serviceofshop_id}}">{{$item->year}}</td>
          <td id="make{{$item->serviceofshop_id}}">{{$item->make}}</td>
          <td id="model{{$item->serviceofshop_id}}">{{$item->model}}</td>
          <td id="term{{$item->serviceofshop_id}}">{{$item->term}}</td> 
          <td id="cylinder{{$item->serviceofshop_id}}">{{$item->cylinder}}</td> 
          <td id="price{{$item->serviceofshop_id}}">{{$item->total_price}}</td>   
          <td id="description{{$item->serviceofshop_id}}">{{$item->descriptions}}</td>                
          <td class="service-edit" id="{{$item->serviceofshop_id}}" style="cursor: pointer;"><i class="fa fa-edit"></i>eidt</td>
          <td class="service-delete" id="{{$item->serviceofshop_id}}" style="cursor: pointer;"><i class="fa fa-trash"></i>delete</td>
        </tr>
      @endforeach 

    </tbody>
 </table>
 <div class="text-center"> 
  {{$services->links()}}             
 </div> 