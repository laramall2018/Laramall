 @if($model->order->order_goods()->get())
    	<div class="alert alert-info">订单中的产品</div>
    	<table class="table table-bordered table-hover table-striped">
    		<tr>
    			<th>商品编号</th>
    			<th>商品图片</th>
    			<th>商品名称</th>
    			<th>商品价格</th>
    		</tr>
    		@foreach($model->order->order_goods()->get() as $item)
    			<tr>
    				<td>{!!$item->id!!}</td>
    				<td>
    					@if($item->goods->thumb())
    						<a href="{{$item->goods->url()}}" target="_blank">
    						<img src="{{$item->goods->thumb()}}" class="img-thumbnail"  style="width:100px;">
    						</a>
    					@endif
    				</td>
    				<td>
    					<a href="{{$item->goods->url()}}" target="_blank">
    						{{$item->goods_name}}
    					</a>
    				</td>
    				<td><span class="org">{{$item->shop_price}}</span></td>
    			</tr>
    		@endforeach
    	</table>
@endif