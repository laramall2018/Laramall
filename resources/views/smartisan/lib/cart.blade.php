<div class="cart-info-bar" id="cartapp">
		<span class="glyphicon glyphicon-shopping-cart" style="font-size: 18px;"></span>
		购物车
		<span class="cart-number-info">@{{rows.cart_all_number}}</span>
		

		<div class="cart-popbox">

			<p v-if="rows.cart_all_number == 0">购物车中没有产品</p>

			<div class="cart-info-item" v-for="cart in rows.cart_list">
				<div class="row">
					<div class="col-md-4">
						<img v-bind:src="cart.thumb" v-bind:alt="cart.goods_name" class="cart-thumb">
					</div>
					<div class="col-md-6">
						<p>@{{cart.short_goods_name}}
						<span class="red">@{{cart.goods_attr}}</span>
						</p>
						<p>
							<span class="price">￥@{{cart.shop_price}}</span>
							<span>x</span>
							<span>@{{cart.goods_number}}</span>
						</p>
					</div>
					<div class="col-md-2 col-md-del">
						<span class="btn-del" v-bind:data-id="cart.id" v-on:click="cartDelete(cart.id)"><i class="fa fa-times"></i> </span>
					</div>
				</div><!--/row-->
			</div><!--/cart-info-item-->
	
			<div class="cart-info-item cart-info-number-item" v-if="rows.cart_all_number">
			<p>共计<span class="number">@{{rows.cart_all_number}}</span>件商品</p>
			</div><!--/cart-info-item-->

			<div class="cart-info-bottom" v-if="rows.cart_all_number">
				<div class="left">
					合计:<span class="amount">￥ @{{rows.cart_all_amount}}</span>
				</div>
				<div class="right">
					<a href="{{url('cart')}}" class="ls-btn-success" v-if="rows.cart_all_number">去购物车</a>
				</div>
			</div><!--/cart-info-bottom-->

		</div><!--/cart-popbox-->

</div><!--/cart-info-bar-->
@include('smartisan.vue.cart')