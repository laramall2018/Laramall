
<div class="order-goods-item">
	<h4>批量付款包含的子订单如下</h4>
	<table class="table table-bordered table-striped order-tab">
		<tr>
			<td>订单编号</td>
			<td>订单金额</td>
		</tr>
		@if($order->childrens())
		@foreach($order->childrens() as $child)
		<tr>
			<td>{{$child->order_sn}}</td>
			<td><span class="price">￥{{$child->order_amount}}</span></td>
		</tr>
		@endforeach
		@endif
	</table>

</div>