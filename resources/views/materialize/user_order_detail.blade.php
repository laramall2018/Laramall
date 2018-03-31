@extends('materialize.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
	@include('materialize.lib.breadcrumb')
    
    <div class="row">
    <div class="col s12">

    <a href="{{$back_url}}" class="btn offset-top10">返回</a>
    @if($order->cancel_status == 0)
    <span data-url="{{url('auth/mobile/order/delete/'.$order->id)}}" class="btn red offset-top10  mobile-cancel-btn">

        取消订单
    </span>
    @endif

    <div class="card-panel">
    	<table class="table striped bordered">
    		<tr>
				<th>订单编号</th>
				<td>{{$order->order_sn}}</td>
    		</tr>
    		<tr>
				<th>商品总金额</th>
				<td><strong class="red-text">￥{{$order->goods_amount}}</strong></td>
    		</tr>
    		<tr>
    			<th>运费</th>
    			<td><strong class="red-text">￥{{$order->shipping_fee}}</strong></td>
    		</tr>
            <tr>
                <th>订单总金额</th>
                <td><strong class="red-text">￥{{$order->order_amount}}</strong></td>
            </tr>
    		<tr>
				<th>订单状态</th>
				<td>{{$order->status()}}</td>
    		</tr>
    		<tr>
    			<th>配送方式</th>
    			<td>{{$order->shipping_name}}</td>
    		</tr>
    		<tr>
    			<th>支付方式</th>
    			<td>
                    <p>{{$order->pay_name}}</p>
                    @if($order->is_pay())
                        <a href="{{url('auth/mobile/pay/'.$order->id)}}" class="btn">
                         <i class="material-icons left">attach_money</i>
                            去支付
                        </a>
                    @endif
                </td>
    		</tr>
    	</table>

    </div>
    </div>
    </div>


    <div class="row">
    <div class="col s12">
    <div class="card-panel">
    	
    	<table class="table striped bordered">
			<tr>
				<th>商品</th>
				<th>金额</th>
			</tr>
			@foreach($order->order_goods()->get() as $item)
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
            <tr>
                <td>总计</td>
                <td><strong class="red-text">￥{{$order->goods_amount}}</strong></td>
            </tr>
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