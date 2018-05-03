
@extends('layouts.app')
@section('content')
<style>
  .document2{
    background-color: #fefefe;
    box-shadow: 2px 5px 5px 2px rgba(0,0,0,0.3);
    padding:15px;
    border-radius: 4px;
  }
</style>
<div class="container">
      <div class="col-md-8 col-md-offset-2 row document2"> 
         <form action="{{route('upload.file')}}" method="post" class="form-horizontal" enctype="multipart/form-data" >    
            {{csrf_field()}}         
            <div class="form-group{{ $errors->has('insurance') ? ' has-error' : '' }} text-center">
               <label class="control-label col-md-4" for="insurance">Business Insurance </label>
               <div class="col-md-8">
                 <input type="file" name="insurance" class="btn btn-default"/>
                  @if ($errors->has('insurance'))
                    <span class="help-block">
                        <strong>{{ $errors->first('insurance') }}</strong>
                    </span>
                  @endif     
                </div>    
            </div>
          
            <div class="form-group{{ $errors->has('license') ? ' has-error' : '' }} text-center">
               <label class="control-label col-md-4" for="license">Business License</label>
               <div class="col-md-8">
                 <input type="file" name="license" class="btn btn-default"/>
                  @if ($errors->has('license'))
                    <span class="help-block">
                        <strong>{{ $errors->first('license') }}</strong>
                    </span>
                  @endif
               </div>
            </div>
            <div class="form-group text-center">
              <input type="submit" value="Upload" class="btn btn-default"/>
            </div>
         </form>
      </div>
</div>
@endsection