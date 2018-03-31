@extends('smartisan.layout.common-cart')

@section('title')
{{$title}}
@stop

@section('content')
	<div class="main-box">
		@include('smartisan.payment.payment')
	    @include('smartisan.payment.info')
	</div>
@stop