@extends('layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/shopcalendar.css')}}">
@endsection

@section('scripts')
<script type="text/javascript" src="{{asset('js/shopcalendar.js')}}"></script>

@endsection
@section('content')
<div class="container">
    this is shop calendar page.
</div>
@endsection