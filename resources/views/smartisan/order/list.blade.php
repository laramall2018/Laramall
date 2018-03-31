<div class="menu-right" id="orderroot">
	<div class="panel panel-goods">
		<div class="panel-heading">
			<h4>
				订单列表
			</h4>
		</div><!--/panel-heading-->
		<div class="panel-body" style="padding: 20px;">
		
			<table class="table table-bordered table-striped table-hover order-tab">
				<tr>
				    <th class="text-center" style="width: 60px;">
				    	<span class="check-all checked-btn" 
				    	      v-on:click="checkedAll"
				    	      v-bind:class="{'checked-on':allSelected == 1}">
				    	      
				    	</span>
				    </th>
					<th class="text-center">日期</th>
					<th class="text-center">订单号</th>
					<th class="text-center">总金额</th>
					<th class="text-center">状态</th>
					<th class="text-center">操作</th>
				</tr>
				<tr v-for="order in rows.order_list">
				    <td class="text-center" style="width: 60px;"> 
				    	<span class="checked-btn order-checked-btn"
				    	      v-on:click="orderSelect"
				    	      v-bind:class="{'checked-on':allSelected == 1}"
				    	      v-bind:data-id="order.id"> 
				    	</span>
				    </td>
					<td style="width: 100px;">@{{order.createTime}}</td>
					<td style="width: 120px;" class="text-center">@{{order.order_sn}}</td>
					<td style="width: 100px;" class="text-center">￥@{{order.order_amount}}</td>
					<td>@{{order.status}}</td>
					<td style="width: 80px;">
						<span class="ls-btn ls-btn-danger" v-on:click="delOrder(order.id)">
							<i class="fa fa-times"></i>
						</span>
						<a v-bind:href="order.url" class="ls-btn">
							<i class="fa fa-eye"></i>
						</a>
					</td>
				</tr>	
			</table><!--/table-->
			<span class="ls-btn-info" v-on:click="mergeOrder">
			    <i class="fa fa-check"></i>
				合并支付
			</span>
		</div><!--/panel-body-->
	</div><!--/panel-goods-->
</div><!--/menu-right-->
@include('smartisan.vue.order') 