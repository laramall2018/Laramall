<div class="row">
	<div class="panel panel-goods">
		<div class="panel-heading">
			<h4>
				<span class="btn sort-btn" 
					  v-on:click="orderBy"
					  data-sort_name="id" 
					  v-bind:class="{'btn-success':rows.sort_name =='id'}">
						综合
						<i class="fa fa-sort-up" v-if="rows.sort_value =='asc' && rows.sort_name =='id' "></i>
						<i class="fa fa-sort-desc" v-if="rows.sort_value =='desc' && rows.sort_name =='id' "></i>
				</span>
				<span class="btn sort-btn" 
					  v-on:click="orderBy"
					  data-sort_name="shop_price"
					  v-bind:class="{'btn-success':rows.sort_name =='shop_price'}">
					  价格
			<i class="fa fa-sort-up" v-if="rows.sort_value =='asc' && rows.sort_name =='shop_price' "></i>
			<i class="fa fa-sort-desc" v-if="rows.sort_value =='desc' && rows.sort_name =='shop_price' "></i>
					  </span>
				<span class="btn sort-btn" 
					  v-on:click="orderBy"
					  data-sort_name="sort_order"
					  v-bind:class="{'btn-success':rows.sort_name == 'sort_order'}">
					  排序值
			<i class="fa fa-sort-up" v-if="rows.sort_value =='asc' && rows.sort_name =='sort_order' "></i>
			<i class="fa fa-sort-desc" v-if="rows.sort_value =='desc' && rows.sort_name =='sort_order' "></i>
					  </span>
				
			</h4>
		</div><!--/panel-heading-->
		<div class="panel-body">
			
			<div class="goods-item ls-col-md-goods" 
			     v-bind:class="['goods-item'+ index]"
				 v-for="(item,index) in rows.goods_list">
				<a v-bind:href="item.url" class="thumb-img">
					<img v-bind:src="item.thumb" v-bind:alt="item.goods_name">
				</a>
				<p class="name">
					<a v-bind:href="item.url">@{{item.short_goods_name}}</a>
				</p>
				<p class="price">￥@{{item.shop_price}}</p>
				
				<div class="gallery-list" v-if="item.gallerys">
					
					<img v-bind:src="gallery.thumbOss" 
						v-bind:alt="item.goods_name" 
						class="gallery-thumb" v-for="gallery in item.gallerys">
					
				</div>
				
				<div class="goods-button">
					<a v-bind:href="item.url" class="btn btn-default">查看详情</a>
					<span class="btn btn-blue-purple" v-on:click="addCart(item.id)">加入购物车</span>
				</div>
			</div><!--/goods-item-->
			
		</div><!--/panel-body-->
	</div>
</div>

<div class="row">
<div class="ls-pagination" v-if="rows.total > 0">
	<span v-if="rows.current_page > 1"
		  v-on:click="changePage(rows.current_page - 1)">
		  <i class="fa fa-arrow-left"></i>
	</span>
	<span class="disable" v-else><i class="fa fa-arrow-left"></i></span>
	<span 	v-for="number in rows.number"
			v-bind:data-page="number"
			v-on:click="changePage(number)"
			v-bind:class="{'active':number == rows.current_page}">
			@{{number}}
	</span>
	<span v-on:click="changePage(rows.current_page + 1)"
		  v-if="rows.last_page > rows.current_page">
		  <i class="fa fa-arrow-right"></i>
	</span>
	<span class="disable" v-else><i class="fa fa-arrow-right"></i></span>
</div>
</div>