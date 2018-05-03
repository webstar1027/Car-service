@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/masterdetail.css')}}">
@endsection
@section('scripts')
<script type="text/javascript" src="{{asset('js/masterdetail.js')}}"></script>
@endsection
@section('content')   
   <div class="container">
      <div class="col-md-12">    
        <div class="master-detail">
          <div class="form-group">
            <h4>Master Service Name</h4>
            <p>{{$masterservice_name}}</p>
          </div>
          <div class="form-group">
            <h4>Show Line Items</h4>
            <?php $count = 1;?>
            <div class="table-responsive">
              <table class="table table-inverse table-bordered">
                <thead>
                  <tr>
                    <td> No </td>
                    <td> Line Item Name </td>
                    <td> Description </td>
                    <td> Price </td>
                  </tr>
                </thead>
                <tbody>
                 @foreach($line_items as $item)
                   <tr>
                     <td> {{$count++}} </td>
                     <td> {{$item['pricetype_name']}} </td>
                     <td> {{$item['description']}} </td>
                     <td> ${{$item['price']}} </td>
                   </tr>
                 @endforeach
                </tbody>
              </table>
            </div>            
          </div>
          <div class="form-group">
            <h4> Price: </h4>
            <div class="table-responsive">
              <table class="table table-inverse table-bordered" id="price_body">
                <thead>
                  <tr>
                    <td>
                      <input id="all" type="checkbox" value="all" />
                      <label for="all"></label>      
                    </td>
                    <td>Service ID</td>
                    <td>Child Service Name</td>
                    <td>Year</td>
                    <td>Make</td>
                    <td>Model</td>
                    <td>Term</td>
                    <?php $count = count($items[0]);?>
                    @for($i=0;$i<$count;$i++)
                      <td>Item {{$i+1}} Price</td>
                    @endfor
                    <td>Total price</td>
                    <td>Status</td>
                    <td>Edit</td>
                    <td>Delete</td>
                  </tr>
                </thead>
                <tbody>
                  <?php $count1 = count($items);?>
                  <input type="hidden" id="master_id" value="{{$id}}"/>
                  @for($i=0;$i<$count1;$i++)                            
                    <tr id="{{$childservices[$i]['serviceofshop_id']}}">
                      <td>
                        <input class="select" id="select{{$childservices[$i]['serviceofshop_id']}}" type="checkbox" value="{{$childservices[$i]['serviceofshop_id']}}" />
                          <label for="select{{$childservices[$i]['serviceofshop_id']}}"></label>      
                       </td>
                      <td>{{$childservices[$i]['serviceofshop_id']}}</td>
                      <td>{{$childservices[$i]['category_name']}}</td>
                      <td>{{$childservices[$i]['year']}}</td>
                      <td>{{$childservices[$i]['make']}}</td>
                      <td>{{$childservices[$i]['model']}}</td>
                      <td>{{$childservices[$i]['term']}}</td>    
                      <?php $count3=1;?>                   
                       @foreach($items[$i] as $childitem)
                         <td>{{$childitem}}</td>
                       @endforeach
                       <td id="total{{$childservices[$i]['serviceofshop_id']}}">{{$childservices[$i]['total_price']}}</td>
                       @if($childservices[$i]['status'] == 0 )
                         <td> active </td>
                       @elseif($childservices[$i]['serviceofshop_id'] == 1)
                         <td> expire </td>
                       @else
                         <td> deactive </td>
                       @endif
                       <td class="edit" style="cursor: pointer;" id="edit{{$childservices[$i]['serviceofshop_id']}}"><i class="fa fa-edit edit"></i>edit</td>
                       <td class="delete" id="delete{{$childservices[$i]['serviceofshop_id']}}" style="cursor: pointer;" onclick="location.href='{{route('detail.delete', ['master_id' => $id, 'id' => $childservices[$i]['serviceofshop_id']])}}'" ><i class="fa fa-trash"></i>delete</td>          
                    </tr>                      
                  @endfor
                </tbody>
              </table>
            </div>
          </div>
          <div class="form-group">
              <h4> Action </h4>
              <select class="form-control" id="service_action">
                 <option selected value=""></option>
                 <option value='renew'>Renew selected</option>
                 <option value="deactive">Deactivate selected</option>
                 <option value="delete">Delete selected</option>
              </select>
              <div class="text-center" style="margin-top:20px;">
                 <button class="btn btn-primary" id="submit">submit</button>
              </div>
            </div>
          </div> 
          <div class="text-center" style="margin-top:40px;">
             <a class="btn btn-primary" href="{{route('pagination')}}"> Back </a>
          </div> 
      </div>
  </div>
  <div class="remodal" data-remodal-id="modal" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
    <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
      <div>
        <h2 id="modal1Title">Warning</h2>
        <p id="modal1Desc">
           You must select one service id at least !
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
           You must select action at least !
        </p>
      </div>
    <br>
    <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
    <button data-remodal-action="confirm" class="remodal-confirm">OK</button>
  </div>
@endsection