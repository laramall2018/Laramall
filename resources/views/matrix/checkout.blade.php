@extends('matrix.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
<link href="{!!url('front/matrix/animate.css')!!}" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{!!url('front/matrix/bootstrap/js/bootstrap.js')!!}"></script>
<link href="{!!url('static/icheck/skins/all.css')!!}" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{!!url('static/icheck/icheck.js')!!}"></script>

   @include('matrix.lib.breadcrumb')
   
   
   <div class="container">
   		  @include('matrix.lib.order.address')
        @include('matrix.lib.order.payment')
        @include('matrix.lib.order.shipping')
        @include('matrix.lib.order.cart_list')
   </div>
 
<script type="text/javascript">
$(function(){
	
	front.cart.del_address("{!!url('checkout-del-address')!!}","{!!csrf_token()!!}","{!!url('checkout')!!}");
	front.cart.def_address("{!!url('checkout-def-address')!!}","{!!csrf_token()!!}","{!!url('checkout')!!}");
	
});
</script>
@stop