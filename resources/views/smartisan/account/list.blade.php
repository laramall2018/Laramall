<div class="menu-right" id="accountroot">
	<div class="panel panel-goods">
		<div class="panel-heading">
			<h4>
				充值提现列表
				<span class="btn btn-success ls-btn-right" data-toggle="modal" data-target="#myModalNew">
					<i class="fa fa-pencil"></i>
					添加
				</span>
			</h4>
		</div><!--/panel-heading-->
		<div class="panel-body" style="padding: 20px;">
			<table class="table table-bordered table-striped table-hover order-tab">
				<tr>
					<th>类型</th>
					<th>时间</th>
					<th>状态</th>
					<th>备注</th>
					<th>IP</th>
					<th>金额</th>
				</tr>
				<tr v-for="account in rows.account_list">
					<td style="width: 60px;">@{{account.typeName}}</td>
					<td style="width: 100px;">@{{account.createTime}}</td>
					<td>@{{account.accountStatus}}</td>
					<td>@{{account.user_note}}</td>
					<td>@{{account.ip}}</td>
					<td class="text-center price" style="width: 100px;">@{{account.amountFormat}}</td>

				</tr>
				<tr>
					<td colspan="5">余额</td>
					<td class="price">@{{rows.money}}</td>
				</tr>
			</table>
		</div><!--/panel-body-->
	</div>
	@include('smartisan.account.popbox')
</div><!--/menu-right-->
@include('smartisan.vue.account')