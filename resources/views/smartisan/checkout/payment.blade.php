
<div class="row" id="payroot">
	<div class="panel panel-goods">
		<div class="panel-heading">
			<h4>支付方式</h4>
		</div><!--/panel-title-->
		<div class="panel-body">
			<div class="pay-list padding20">
				<div class="pay-item" v-for="payment in rows.payment_list">

					<img v-bind:src="payment.paymentIcon"
						 v-bind:class="{'active-img':pay_id == payment.id}"
						 v-on:click="changePayment(payment.id)"
						v-bind:alt="payment.pay_name">
				</div><!--/pay-item-->
			</div><!--/pay-list-->
		</div><!--/panel-body-->
	</div><!--/panel-->
</div><!--/row payroot-->
@include('smartisan.vue.payment') 