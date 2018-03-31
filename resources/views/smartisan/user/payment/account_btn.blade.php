
@extends('smartisan.layout.common')

@section('title')
{{$title}}
@stop

@section('content')
	<div class="main-box">
		
		<div class="container" id="acpay">
			<div class="panel panel-goods">
				<div class="panel-heading">
					<h4>使用余额支付订单</h4>
				</div>
				<div class="panel-body" style="padding:30px;">
					<table class="table table-bordered table-hover table-striped order-tab">
						<tr>
							<th>订单编号</th>
							<td>{{$order->order_sn}}</td>
						</tr>
						<tr>
							<th>订单状态</th>
							<td>
								{{$order->status()}}
							</td>
						</tr>
						<tr>
							<th>订单总金额</th>
							<td><span class="price">￥{{$order->order_amount}}</span></td>
						</tr>
						<tr>
							<th>用户余额</th>
							<td><span class="price">￥{{$user->money()}}</span></td>
						</tr>
					</table>
					<div class="ls-btn-info" v-on:click="accountPay">立即余额支付</div>
					<a href="{{url('order/payment/'.$order->id)}}" class="ls-btn-default">返回订单</a>
				</div>
			</div>
		</div>
	</div><!--/main-box-->
	@include('smartisan.vue.accountpay')
@stop