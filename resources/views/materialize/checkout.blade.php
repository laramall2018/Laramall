@extends('materialize.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
       @include('materialize.lib.breadcrumb')
       @include('materialize.lib.cart.address')
       @include('materialize.lib.payment')
       @include('materialize.lib.shipping')
       @include('materialize.lib.checkout.goods')
	   @include('materialize.lib.checkout.submit')

	   <script type="text/javascript">

 		$(function(){

 			front.checkout.shipping("{!!url('shipping-ajax')!!}","{!!csrf_token()!!}");

 			front.checkout.submit("{!!url('mobile-order')!!}","{!!csrf_token()!!}")
 		});

		</script>
       
@stop