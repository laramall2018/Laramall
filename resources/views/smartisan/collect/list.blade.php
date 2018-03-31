<div class="menu-right" id="collectroot">
	<div class="panel panel-goods">
		<div class="panel-heading">
			<h4>
				收藏商品
				<span class="btn btn-success ls-btn-right" data-toggle="modal" data-target="#myModalNew">
					<i class="fa fa-pencil"></i>
					添加
				</span>
			</h4>
		</div><!--/panel-heading-->
		<div class="panel-body" style="padding: 20px;">
			<table class="table table-bordered table-striped table-hover order-tab">
				<tr>
					<th>商品信息</th>
					<th>收藏时间</th>
					<th>操作</th>
				</tr>
				<tr v-for="collect in rows.collect_list">
					<td>
						<a v-bind:href="collect.goodsUrl" target="_blank">
						<img  v-bind:src="collect.thumb" 
						      class="order-thumb img-circle" 
						      v-bind:alt="collect.goodsName">
						<span v-text="collect.goodsName"></span>
						</a>
					</td>
					<td class="text-center" style="width: 100px;">@{{collect.createTime}}</td>
					<td class="text-center" style="width: 60px;">
						<span class="ls-btn ls-btn-danger" v-on:click="delCollect(collect.id)">
							<i class="fa fa-times"></i>
						</span>
					</td>
				</tr>
			</table>
		</div><!--/panel-body-->
	</div>
	@include('smartisan.collect.popbox')
</div><!--/menu-right-->
@include('smartisan.vue.collect')