<div class="menu-right">
	<div class="panel panel-goods" id="addressapp">
		<div class="panel-heading">
			<h4>
				用户地址
				<span class="btn btn-success ls-btn-right" data-toggle="modal" data-target="#myModalNew">
					<i class="fa fa-pencil"></i>
					添加
				</span>
			</h4>
		</div><!--/panel-heading-->
		<div class="panel-body" style="padding:20px;">
			<table class="table table-bordered table-striped order-tab">
				<tr>
					<th>姓名</th>
					<th>详细地址</th>
					<th>电话</th>
					<th>操作</th>
				</tr>
				<tr v-for="address in rows.address_list">
					<td>@{{address.consignee}}</td>
					<td>@{{address.addressName}}</td>
					<td>@{{address.phone}}</td>
					<td style="width: 80px;">
					   <span class="ls-btn ls-btn-danger" v-on:click="delAddress(address.id)">
					   	 <i class="fa fa-times"></i>
					   </span>
					   <span class="ls-btn ls-btn-primary" 
					   		data-toggle="modal" 
					   		v-bind:data-target="'#myModal'+address.id">
					   	 <i class="fa fa-pencil"></i>
					   </span>
					   @include('smartisan.address.popbox')
					</td>
				</tr>
			</table>
		</div><!--/panel-body-->
		@include('smartisan.address.popbox_new')
	</div><!--/panel-goods-->
</div><!--/menu-right-->
@include('smartisan.vue.address')