<div class="row" id="shippingroot">
	<div class="panel panel-goods">
		<div class="panel-heading">
			<h4>配送方式</h4>
		</div><!--/panel-heading-->
		<div class="panel-body">
			<div class="shipping-content padding20">
				<span class="shipping-item"
				      v-on:click="selectShipping(shipping.id)"
				      v-bind:class="{'shipping-item-active':shipping.id == shipping_id}"
					  v-for="shipping in rows.shipping_list">
					@{{shipping.shipping_name}}
				</span><!--/shipping-item-->
			</div><!--/shipping-content-->
		</div><!--/panel-body-->
	</div><!--/panel-->
</div><!--/row $shippingroot-->
@include('smartisan.vue.shipping')