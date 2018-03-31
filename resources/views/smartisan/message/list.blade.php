<div class="menu-right" id="msgroot">
	<div class="panel panel-goods">
		<div class="panel-heading">
			<h4>
				留言列表
				<span class="btn btn-success ls-btn-right" v-on:click="addMsg">
					<i class="fa fa-pencil"></i>
					添加
				</span>
			</h4>
		</div><!--/panel-heading-->
		<div class="panel-body" style="padding: 20px;">
			<table class="table table-bordered table-striped table-hover order-tab">
				<tr>
					
					
					<th>类型</th>
					<th>状态</th>
					<th>留言内容</th>
					<th>有回复</th>
					<th>时间</th>
					<th>操作</th>
				</tr>
				<tr v-for="message in rows.message_list">
					
					<td style="width: 80px;">@{{message.type}}</td>
					<td style="width: 80px;">@{{message.statusFormat}}</td>
					<td>@{{message.content}}
					</td>
					<td style="width: 80px;">@{{message.hasReply}}</td>
					<td style="width: 100px;">@{{message.createTime}}</td>
					<td style="width: 80px;">
						<span class="ls-btn ls-btn-danger" v-on:click="delMsg(message.id)">
							<i class="fa fa-times"></i>
						</span>
						<span class="ls-btn ls-btn-primary" v-on:click="showMsg(message)">
							<i class="fa fa-eye"></i>
						</span>
					</td>
				</tr>
			</table>
		</div><!--/panel-body-->
	</div><!--/panel-->
</div><!--/menu-right-->
@include('smartisan.vue.message')