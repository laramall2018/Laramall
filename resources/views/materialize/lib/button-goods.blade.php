<div class="row right-align">
<div class="col s12">

	<span class="btn red" id="buy-btn" data-goods_id="{!!$goods->id!!}">
 	<i class="material-icons left">shopping_cart</i>
 	{!!trans('front.buy')!!}
   </span>

	<span class="btn blue" id="cart-btn" data-goods_id="{!!$goods->id!!}">
 	<i class="material-icons small left">shopping_basket</i>
 	{!!trans('front.add_to_cart')!!}
    </span>

</div>
</div>

<!-- 商品购物按钮结束 -->

<script type="text/javascript">
	$(function(){

		front.goods.buy("{!!url('ajax-buy')!!}","{!!url('cart')!!}");
	})
</script>
