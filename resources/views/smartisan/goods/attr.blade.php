<div id="goodsapp">
<div class="goods-detail-attr-list" v-if="attr_list">
	<div class="goods-detail-attr-item" v-for="attr in attr_list">
		<span class="attr-name">
			@{{attr.attr_name}}
		</span>
		<span class="attr-value" 
		      v-on:click="changeAttr"
		      v-bind:data-goods_attr_id="attr_value.id"
			  v-for="attr_value in attr.attr_value">
			@{{attr_value.attr_value}}
		</span>
	</div>

	<div class="goods-detail-attr-item" v-if="goods_attr_values.length > 0">
		<span class="attr-name">
			已选
		</span>
		<span class="selected" v-for="attr_value in goods_attr_values">
			@{{attr_value.attr_value}}
		</span>
	</div>
</div>

<div class="goods-number">
	<span class="tit">数量</span>
	<span class="sub-btn" v-on:click="subGoodsNumber"></span>
	<input type="text" v-model='goods_number' class="nobor">
	<span class="add-btn" v-on:click="addGoodsNumber"></span>
</div><!--/goods-number-->

<div class="goods-detail-btn">
	<span class="ls-btn-info" v-on:click="addCart">加入购物车</span>
	<span class="ls-btn-default" v-on:click="buy">立即购买</span>
	<p>*7 天无理由退货，15 天免费换货，满 150 元免运费。</p>
</div><!--/goods-detail-btn-->
</div><!--/goodsapp-->

@include('smartisan.vue.goods')