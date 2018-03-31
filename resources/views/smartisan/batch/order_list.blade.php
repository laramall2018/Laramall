
<div class="order-sn-list" v-if="orders.length > 0 ">
	
	<div class="alert alert-success">
		<p><i class="fa fa-check"></i>批量下单成功</p>
	</div>
	<div class="alert alert-info" v-for="order in orders">
		<p>
			<a v-bind:href="order.url" target="_blank">
			 订单号：@{{order.order_sn}}
			</a>
		</p>
	</div><!--/alert-->

	<span class="ls-btn-default" v-on:click="resetInput">返回重新下单</span>

</div><!--/order-sn-list-->