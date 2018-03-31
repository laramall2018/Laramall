
<div class="goods-text-box">
    <div class="goods-name-title">
		<h3>{{$goods->goods_name}}</h3>
		<h4><small>{{$goods->goods_sn}}</small></h4>
		<h4><small>品牌：{{$goods->brand_name()}}</small></h4>
		<span class="shop_price">￥{{$goods->shop_price}}</span>
	</div><!--/goods-name-title-->
	@include('smartisan.goods.attr')
</div><!--/goods-text-box-->