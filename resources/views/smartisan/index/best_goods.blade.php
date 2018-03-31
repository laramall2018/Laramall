
<div class="row">
<div class="panel panel-goods">
	<div class="panel-heading">
		<h4>精品推荐</h4>
	</div><!--/ls-goods-panel-header-->
	<div class="panel-body">
		
		<div class="goods-item ls-col-md-goods" v-for="(item,index) in rows.best" v-bind:class="['goods-item'+index]">
			<a v-bind:href="item.url" class="thumb-img">
				<img v-bind:src="item.thumb" v-bind:alt="item.goods_name">
			</a>
			<p class="name">
				<a v-bind:href="item.url">@{{item.short_goods_name}}</a>
			</p>
			<p class="price">
				￥@{{item.shop_price}}
			</p>

			
			<div class="gallery-list">
			<img v-bind:src="gallery.thumbOss" v-bind:alt="item.goods_name" class="gallery-thumb" v-for="gallery in item.gallerys">
			</div>
		

			<div class="goods-button">
				<a v-bind:href="item.url" class="btn btn-default">查看详情</a>
				<span class="btn btn-blue-purple" v-on:click="addCart(item.id)">加入购物车</span>
			</div>
		</div>
	</div><!--/ls-goods-panel-body-->
</div><!--/ls-goods-panel-->
</div><!--/row-->
