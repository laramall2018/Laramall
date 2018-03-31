@extends('smartisan.layout.common-cart')

@section('title')
{{$title}}
@stop

@section('content')
	<div class="main-box">
		@include('smartisan.checkout.address')
		@include('smartisan.checkout.fp')
		@include('smartisan.checkout.payment')
		@include('smartisan.checkout.shipping')
	    @include('smartisan.checkout.goods')
	</div>
@stop