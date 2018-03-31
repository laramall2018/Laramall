<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>{!!$title!!}</title>
<link href="{!!url('files/bootstrap/css/bootstrap.min.css')!!}" type="text/css" rel="stylesheet" />
<link href="{!!url('files/font-awesome/css/font-awesome.min.css')!!}" type="text/css" rel="stylesheet" />
<link href="{!!url('files/style.css')!!}" type="text/css" rel="stylesheet" />
<link href="{!!url('files/css/hoe.css')!!}" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="{!!url('files/jquery.min.js')!!}"></script>
<script type="text/javascript" src="{!!url('files/hoe.js')!!}"></script>
<script type="text/javascript" src="{!!url('files/phpstore.js')!!}"></script>
</head>
<body>
	
	<div class="container-fluid">
	<div class="table-responsive" style="margin-top: 50px;">
	<h3 class="text-center">订单信息</h3>
	<table class="table table-striped table-bordered table-hover">
		
		<tr>
			<th>收货人</th>
			<th>订单编号</th>
			<th>支付方式</th>
			<th>配送方式</th>
			<th>快递单号</th>
			<th>下单时间</th>
			<th>订单状态</th>
			<th>订单总金额</th>
		</tr>
		<tr>
			<td>{!!$order->consignee!!}</td>
			<td>{!!$order->order_sn!!}</td>
			<td>{!!$order->pay_name!!}</td>
			<td>{!!$order->shipping_name!!}</td>
			<td>
			@if($express)
				{!!$express->express_sn!!}
			@endif
			</td>
			<td><?php echo date('Y-m-d',$order->add_time);?></td>
			<td>{!!$order_status!!}</td>
			<td>
			{!!$order->order_amount!!}
			</td>
		</tr>
	
	</table>
	
	<h3>订单产品列表</h3>
	<table class="table table-striped table-bordered table-hover">
		
		<tr>
			<th>商品编号</th>
			<th>商品名称</th>
			<th>商品价格</th>
			<th>商品数量</th>
		</tr>
		@foreach($goods_list as $item)
		<tr>
			<td>{!!$item->goods_id!!}</td>
			<td>{!!$item->goods_name!!}</td>
			<td>{!!$item->shop_price!!}</td>
			<td>{!!$item->goods_number!!}</td>
		</tr>
		@endforeach
	
	</table>
	
	</div><!--/table-responesive-->
	</div><!--/container-fluid-->
</body>
</html>
