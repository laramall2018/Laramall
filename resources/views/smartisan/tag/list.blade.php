<div class="menu-right" id="tagroot">
	<div class="panel panel-goods">
		<div class="panel-heading">
			<h4>
				商品标签
				<span class="btn btn-success ls-btn-right" data-toggle="modal" data-target="#myModalNew">
					<i class="fa fa-pencil"></i>
					添加
				</span>
			</h4>
		</div>
		<div class="panel-body" style="padding:20px;">
			<table class="table table-bordered table-striped table-hover">
				<tr>
					<th>标签</th>
					<th>商品</th>
					<th>操作</th>
				</tr>
				<tr v-for="tag in rows.tag_list">
					<td>@{{tag.tag_name}}</td>
					<td>
						<a v-bind:href="tag.goodsUrl" target="_blank">
							@{{tag.goodsName}}
						</a>
					</td>
					<td style="width: 50px;">
						<span class="ls-btn ls-btn-danger" v-on:click="deleteTag(tag.id)">
							<i class="fa fa-times"></i>
						</span>
					</td>
				</tr>
			</table>
		</div><!--/panel-body-->
		@include('smartisan.tag.popbox')
	</div><!--panel-->
</div><!--/menu-right-->
@include('smartisan.vue.tag')