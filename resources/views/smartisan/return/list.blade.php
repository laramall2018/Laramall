<div class="menu-right" id="returnroot">
	<div class="panel panel-goods">
		<div class="panel-heading">
			<h4>
				退货单列表
				<span class="btn btn-success ls-btn-right" data-toggle="modal" data-target="#myModalNew">
					<i class="fa fa-pencil"></i>
					添加
				</span>
			</h4>
		</div><!--/panel-heading-->
		<div class="panel-body" style="padding: 20px;">
			<table class="table table-bordered table-striped table-hover order-tab">
				<tr>
					<th>订单号</th>
					<th>时间</th>
					<th>状态</th>
					<th>操作</th>
				</tr>
				<tr v-for="item in rows.return_list">
					<td>@{{item.orderSn}}</td>
					<td>@{{item.createTime}}</td>
					<td>@{{item.statusFormat}}</td>
					<td style="width: 100px;" class="text-center">
						<a class="ls-btn" v-bind:href="item.url">
							<i class="fa fa-eye"></i>
						</a>
						<span class="ls-btn ls-btn-danger" v-on:click="delConfirm(item.id)">
							<i class="fa fa-times"></i>
						</span>	
					</td>
				</tr>
			</table>
		</div><!--/panel-body-->
	</div>
	@include('smartisan.return.popbox')
</div><!--/menu-right-->
@include('smartisan.vue.return')