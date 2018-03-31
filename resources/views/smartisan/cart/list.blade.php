<div id="cartpageapp">
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
				    <th>&nbsp;</th>
					<th>名称</th>
					<th>价格</th>
					<th>数量</th>
					<th>小计</th>
					<th>操作</th>
				</tr>
				<tr 
				    v-bind:class="{'tr-last':rows.cart_list.length == (index + 1)}"
					v-for="(cart,index) in rows.cart_list">
					<td class="checkbox-td">
						<span class="checked-btn" 
							  v-on:click="isChecked(cart.id)"
						      v-bind:class="{'checked-on':cart.is_checked == 1}"></span>
					</td>
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
					    <span class="sub-btn" v-on:click="subCart(cart.id)"></span>
						<span class="number">@{{cart.goods_number}}</span>
						<span class="add-btn" v-on:click="addCart(cart.id)"></span>
					</td>
					<td>￥@{{cart.total}}</td>
					<td class="del-btn-td">
						<span class="del-btn" v-on:click="deleteCart(cart.id)"></span>
					</td>
				</tr>
			</table>
			</div><!--/panel-body-->
			<div class="panel-footer" v-if="rows.cart_all_number > 0">
			<div class="row">
				<div class="choose-all">
					<span id="checked-all" 
					      class="checked-btn"
					      v-on:click="checkedAll"
					      v-bind:class="{'checked-on':rows.is_all_checked == 1}"></span>
					<span>全选</span>
				</div>
				<div class="shipping-info">

				    <span class="txt">共<span class="red">@{{rows.cart_all_number}}</span>件商品</span>
				    <span class="txt">已经选择 <span class="red">@{{rows.cart_checked_number}}</span>件商品</span>
				    <span class="shop_price">总计：<span class="red">￥@{{rows.cart_checked_amount}}</span></span>
					<a href="{{url('checkout')}}" class="ls-btn-info" v-if="rows.cart_checked_amount > 0">立即结算</a>
				</div>
		    </div><!--/footer-bb-->
			</div><!--/bottom-->
	   </div><!--/panel-->
	</div><!--/row-->
</div><!--/cartpageapp-->
@include('smartisan.vue.cartpage')