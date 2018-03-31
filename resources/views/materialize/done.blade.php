@extends('materialize.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
       @include('materialize.lib.breadcrumb')
       <div class="row">
	   <div class="col s12">
	   <div class="card-panel">
	   
	   <p>订单编号：<strong class="red-text">{!!$order->order_sn!!}</strong></p>
	   <p>总金额:<strong class="red-text">{!!$order->order_amount!!}</strong></p>

	   @if($pay_btn)
        {!!$pay_btn!!}
        @endif

	   </div><!--/card-panel-->
	   </div><!--/col s12-->
       </div><!--/row-->
       
@stop