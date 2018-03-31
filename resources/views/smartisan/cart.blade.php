@extends('smartisan.layout.common-cart')

@section('title')
{{$title}}
@stop

@section('content')
	<div class="main-box">
	    @include('smartisan.cart.list')
	</div>
@stop