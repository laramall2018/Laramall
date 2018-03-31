<div class="row">
	<div class="panel panel-goods">
		<div class="panel-heading">
			<h4>订单基本信息</h4>
		</div><!--/panel-heading-->
		<div class="panel-body">
			<div class="payment-info">
			 @include('smartisan.payment.order'.$order->order_type)
			</div><!--/info-->
		</div><!--/panel-body-->
	</div><!--/panel-->
</div><!--/row-->