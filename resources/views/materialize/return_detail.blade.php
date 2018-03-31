@extends('materialize.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
	@include('materialize.lib.breadcrumb')

	<div class="row">
	<div class="col s12">
	<a href="{{$back_url}}" class="btn offset-top10">返回</a>
	<span data-url=" {{url('auth/mobile/return/delete/'.$model->id)}} " class="btn red offset-top10 mobile-cancel-btn">删除退货单</span>
	<div class="card-panel">
		
	<table class="table bordered striped">
		<tr>
			<th>
			订单编号
			</th>
			<td>
				<a href="{{url('auth/mobile/order/'.$model->order_id)}}">{{$model->order->order_sn}}</a>
			</td>
		</tr>
		<tr>
			<th>退货人</th>
			<td>{{$model->username}}</td>
		</tr>
		<tr>
			<th>退货类型</th>
			<td> {{$model->type}} </td>
		</tr>
		<tr>
			<th>退货说明</th>
			<td> {{$model->return_note}} </td>
		</tr>
		<tr>
			<th>银行信息</th>
			<td> {{$model->bank_name}} </td>
		</tr>
		<tr>
			<th>银行账号</th>
			<td> {{$model->bank_account}} </td>
		</tr>
		<tr>
			<th>退款金额</th>
			<td> <strong class="red-text">￥{{$model->return_amount}}</strong> </td>
		</tr>
		<tr>
			<th>退货状态</th>
			<td><strong class="red-text"> {{$model->status()}} </strong></td>
		</tr>
		<tr>
			<th>退货来源</th>
			<td>{{$model->reg_from}}</td>
		</tr>
	</table>

	</div>
	</div>
	</div>

	<!--订单中的产品信息-->
	<div class="row">
	<div class="col s12">
	<div class="card-panel">
		
		<table class="table striped bordered">
			<tr>
				<th>商品</th>
				<th>金额</th>
			</tr>
			@foreach($model->order->order_goods()->get() as $item)
			@if($item->goods)
			<tr>
				<td>
					@if($item->goods->gallery())
					<p>
					 <img src="{{url($item->goods->gallery()->first()->thumb())}}" class="cart-thumb-min">
					</p>
					@else
					<p>
					 <img src="{{url('front/matrix/images/phpstore-def.png')}}" class="cart-thumb-min">
					</p>
					@endif
                    <p>
                        <a href="{{$item->goods->url()}}">{{$item->goods->goods_name}}</a>
                    </p>
                    <p>{{$item->goods_attr}}</p>
                    <p>
                        <strong class="red-text">￥{{$item->shop_price}}</strong>
                    </p>
                    <p>
                        数量:{{$item->goods_number}}
                    </p>
				</td>
				<td>
                      <strong class="red-text">￥{{$item->total()}}</strong>          
                </td>
			</tr>
			@endif

			@endforeach
		</table>

	</div>
	</div>
	</div>

	<script type="text/javascript">
        $(function(){

            front.mobile.dom_cancel();
        })
    </script>

@stop