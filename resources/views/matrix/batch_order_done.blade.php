@extends('matrix.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
<link href="{!!url('front/matrix/animate.css')!!}" rel="stylesheet" type="text/css" />
<link href="{!!url('static/icheck/skins/all.css')!!}" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{!!url('static/icheck/icheck.js')!!}"></script>
	
	@include('matrix.lib.breadcrumb')

	<div class="container">
	<div class="row">
	<div class="col-md-12">
		
		<div class="alert alert-success">
			<p><i class="fa fa-check"></i>批量下单成功</p>
		</div>
		@if($order)

		{!!Form::open(['url'=>'auth/batch-pay','method'=>'post'])!!}
		@foreach($order as $item)
		<div class="alert alert-info">
		    <input type="checkbox" name="ids[]" value="{{$item->id}}" checked="checked" class="mycheckbox">
			<a href="{{url('order-done?order_id='.$item->id)}}" target="_blank">订单号：{{$item->order_sn}}</a>
			金额：<span class="org">{{$item->amount()}}</span>
		</div>
		@endforeach
		
		<button type="submit" class="btn btn-success offset-bottom-20">
			批量支付
		</button>
		{!!Form::close()!!}

		@else
		<div class="alert alert-danger">
			<i class="fa fa-times"></i>
			暂时无订单
		</div>
		@endif

		

		<a href="{{url('auth/batch-order')}}" class="btn btn-info offset-bottom-20">
			继续下单
		</a>
	
	</div>
	</div>
	</div>

	<script type="text/javascript">
	$(function(){
		front.icheckbox();
	})
   </script>

@stop