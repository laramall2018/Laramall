<div class="menu-right">
	<div class="panel panel-goods">
		<div class="panel-heading">
			<h4>订单详情</h4>
		</div><!--/panel-heading-->
		<div class="panel-body" style="padding: 20px;">
			<h4 class="tit">订单基本信息</h4>
			<table class="table table-bordered table-striped table-hover order-tab order-detail-tab">
				<tr>
					<th>订单号</th>
					<td>{{$order->order_sn}}</td>
				</tr>
				<tr>
					<th>订单金额</th>
					<td class="price">￥{{$order->order_amount}}</td>
				</tr>
				<tr>
					<th>下单日期</th>
					<td>{{$order->time()}}</td>
				</tr>
				<tr>
					<th>订单状态</th>
					<td>{{$order->status()}}</td>
				</tr>
				
			</table>
			<h4 class="tit">商品信息</h4>
			<table class="table table-bordered table-hover table-striped order-tab">
				<tr>
					<th>商品图片</th>
					<th>商品名称</th>
					<th>价格</th>
					<th>数量</th>
					<th>总计</th>
				</tr>
				@foreach($order->order_goods()->get() as $item)
				<tr>
					<td style="width: 120px;">
						<a href="{{$item->goods->url()}}" target="_blank">
						<img class="order-thumb img-thumbnail" 
							 src="{{$item->goods->thumb()}}" 
							 alt="{{$item->goods_name}}">
						</a>
					</td>
					<td>
						<a href="{{$item->goods->url()}}" target="_blank">
							{{$item->goods_name}}
							<small>{{$item->goods_attr}}</small>
						</a>
					</td>
					<td style="width: 100px;" class="text-center">￥{{$item->shop_price}}</td>
					<td style="width: 50px;" class="text-center">{{$item->goods_number}}</td>
					<td style="width: 100px;" class="text-center">￥{{$item->total()}}</td>
				</tr>
				@endforeach
				<tr>
					<td colspan="4">商品总计</td>
					<td class="price">￥{{$order->goods_amount}}</td>
				</tr>
				<tr>
					<td colspan="4">运费</td>
					<td class="price">￥{{$order->shipping_fee}}</td>
				</tr>
				<tr>
					<td colspan="4">折扣</td>
					<td class="price">
						@if($order->card)
						-￥{{$order->card->price}}
						@else
						￥0
						@endif
					</td>
				</tr>
				<tr>
					<td colspan="4">订单总计</td>
					<td class="price">￥{{$order->order_amount}}</td>
				</tr>
			</table>

			<h4 class="tit">支付方式</h4>
			<table class="table table-bordered table-striped table-hover order-tab order-detail-tab">
				<tr>
					<th>支付名称</th>
					<td>
						<img src="{{$order->payment->paymentIcon}}" alt="">
					</td>
				</tr>
				<tr>
					<th>支付状态</th>
					<td>
						{{$order->presenter()->pay_status}}

						@if($order->presenter()->paylink)
						<a href="{{$order->presenter()->paylink}}" target="_blank">立即支付</a>
						@endif
					</td>
				</tr>
			</table>
			<h4 class="tit">配送信息</h4>
			<table class="table table-bordered table-striped table-hover order-tab order-detail-tab">
				<tr>
					<th>配送方式</th>
					<td>{{$order->shipping_name}}</td>
				</tr>
				<tr>
					<th>运费</th>
					<td class="price">￥{{$order->shipping_fee}}</td>
				</tr>
				@if($order->express())
				<tr>
					<th>快递单号</th>
					<td class="price">{{$order->express()->express_sn}}</td>
				</tr>
				@endif
			</table>

			<h4 class="tit">收货人信息</h4>
			<table class="table table-bordered table-striped table-hover order-tab order-detail-tab">
				<tr>
					<th>收货人姓名</th>
					<td>{{$order->consignee}}</td>
				</tr>
				<tr>
					<th>手机</th>
					<td>{{$order->phone}}</td>
				</tr>
				<tr>
					<th>地址</th>
					<td class="price">{{$order->address()}}</td>
				</tr>

			</table>

			@if($order->fp)
			<h4 class="tit">发票信息</h4>
			<table class="table table-bordered table-striped table-hover order-tab order-detail-tab">
				<tr>
					<th>发票类型</th>
					<td>{{$order->fp->fpTypeName}}</td>
				</tr>
				<tr>
					<th>发票抬头</th>
					<td>{{$order->fp->fp_title}}</td>
				</tr>
				<tr>
					<th>发票内容</th>
					<td>商品购买明细-({{$order->fp->fpGoodsContent}})</td>
				</tr>
			</table>
			@endif
			<a href="{{url('auth/order')}}" class="btn btn-success">
				<i class="fa fa-undo"></i>
				返回
			</a>
		</div><!--/panel-body-->
	</div><!--/panel-goods-->
</div><!--/menu-right-->