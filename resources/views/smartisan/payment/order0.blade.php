<div class="payment-item">
<h4>订单信息</h4>
<p>{{$order->order_sn}}</p>	
</div><!--/payment-item-->
<div class="payment-item">
	<h4>收货人信息</h4>
	<p>{{$order->consignee}}</p>
	<p>{{$order->phone}}</p>
	<p>{{$order->address()}}</p>
</div><!--/payment-item -->

@if($order->fp)
<div class="payment-item">
	<h4>发票信息</h4>
	<p>发票类型：{{$order->fp->fpTypeName}}</p>
	<p>发票抬头：{{$order->fp->fp_title}}</p>
	<p>发票内容:购买商品明细</p>
</div>
@endif

<div class="order-goods-item">
	<h4>订单商品信息</h4>
	<table class="table table-bordered table-striped">
		<tr>
			<th>商品信息</th>
			<th>单价</th>
			<th>数量</th>
			<th>小计</th>
		</tr>
		@foreach($order->order_goods()->get() as $goods)
		<tr>
			<td>
				{{$goods->goods_name}}
				<span class="price">{{$goods->goods_attr}}</span><br>
				<small>{{$goods->goods_sn}}</small>
			</td>
			<td>￥{{$goods->shop_price}}</td>
			<td>{{$goods->goods_number}}</td>
			<td>￥{{$goods->total()}}</td>
		</tr>
		@endforeach
		<tr>
			
			<td colspan="3">运费</td>
			<td>￥{{$order->shipping_fee}}</td>
		</tr>
		<tr>
			<td colspan="3">折扣</td>
			<td>
			  @if($order->card)
				-￥{{$order->card->price}}
			  @else
			   - ￥0
			  @endif
			</td>
		</tr>
		<tr>
			<td colspan="3">订单金额</td>
			<td>￥{{$order->order_amount}}</td>
		</tr>
	</table>
</div><!--/payment-item-->
