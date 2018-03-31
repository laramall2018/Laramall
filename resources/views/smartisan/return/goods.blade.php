<h4 class="tit">订单商品列表</h4>
<table class="table table-bordered table-striped table-hover order-tab">
	<tr>
		<th>商品图片</th>
		<th>商品名称</th>
		<th>商品价格</th>
		<th>数量</th>
	</tr>
	@foreach($model->order->order_goods()->get() as $item)
	<tr>
		<td style="width: 150px;" class="text-center">
			<a href="{{$item->goods->url()}}">
			<img class="user-thumb img-circle" 
				 src="{{$item->goods->thumb()}}" 
				 alt="{{$item->goods_name}}">
			</a>
		</td>
		<td>{{$item->goods_name}}<small class="price">{{$item->goods_attr}}</small></td>
		<td class="price text-center" style="width: 100px;" >{{$item->shop_price}}</td>
		<td class="text-center" style="width: 50px;">{{$item->goods_number}}</td>
	</tr>
	@endforeach
</table>