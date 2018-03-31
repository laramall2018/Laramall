
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
					<div class="alert alert-danger">
						<i class="fa fa-times"></i>
						{{$info}}
					</div>
					<a href="{{url('auth/order')}}" class="ls-btn-default">返回订单</a>
				</div>
			</div>
		</div>
	</div><!--/main-box-->
	
@stop