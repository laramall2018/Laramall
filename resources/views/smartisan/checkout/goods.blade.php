<div id="checkoutroot">
	<div class="row">
		<div class="panel panel-goods">
			<div class="panel-heading">
				<h4>购物清单</h4>
			</div><!--/panel-heading-->
			<div class="panel-body">
			<div id="empty-info" class="alert alert-danger" v-if="rows.cart_all_number == 0">
				<i class="fa fa-times"></i>
				购物车为空
			</div>
			<table class="table table-cart" v-else>
				<tr>
					<th>名称</th>
					<th>价格</th>
					<th>数量</th>
					<th>小计</th>
				</tr>
				<tr 
				    v-bind:class="{'tr-last':rows.cart_list.length == (index + 1)}"
					v-for="(cart,index) in rows.cart_list">
					
					<td>
						<a v-bind:href="cart.url">
						<img v-bind:src="cart.thumb" v-bind:alt="cart.goods_name"  class="cart-thumb">
						</a>
						<a v-bind:href="cart.url">
						@{{cart.goods_name}}
						<span class="attr-value">@{{cart.goods_attr}}</span>
						</a>
					</td>
					<td>￥@{{cart.shop_price}}</td>
					<td>
						<span class="number">@{{cart.goods_number}}</span>
					</td>
					<td>￥@{{cart.total}}</td>
					
				</tr>
				<tr class="tr-last">
					<td colspan="2"></td>
					<td><strong>商品总计</strong></td>
					<td>
						<span class="red">￥@{{rows.cart_checked_amount}}</span>
					</td>
				</tr>
				<tr class="tr-nobor">
					<td colspan="2"></td>
					<td><strong>运费</strong></td>
					<td>
						<span class="red">￥@{{shipping_fee}}</span>
					</td>
				</tr>

				<tr class="tr-nobor">
					<td colspan="2"></td>
					<td><strong>优惠折扣</strong></td>
					<td>
						<span class="red">-￥@{{discount}}</span>
					</td>
				</tr>
				<tr class="tr-nobor">
					<td colspan="2"></td>
					<td><strong>总计</strong></td>
					<td><span class="red">
						￥@{{order_amount}}
					</span></td>
				</tr>

			</table>
			</div><!--/panel-body-->
			<div class="panel-footer" v-if="rows.cart_all_number > 0">
			   <div class="row padding20">
			   			@include('smartisan.checkout.giftcard')
			   </div><!--/row-->
			</div><!--/panel-footer-->
	   </div><!--/panel-->
	</div><!--/row-->
</div><!--/cartpageapp-->
@include('smartisan.vue.checkout')