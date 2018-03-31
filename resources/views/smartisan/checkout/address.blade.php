
<div class="row" id="addressapp">
<div class="panel panel-goods">
	<div class="panel-heading">
		<h4>收货地址</h4>
	</div><!--/panel-heading-->
	<div class="panel-body">
		<div class="row padding20">
			<div class="col-md-3" v-for="(address,index) in rows.address_list">
			    <div class="address-item" v-bind:class="{'address-item-active':address.isDefault == 1}">
			    	<h4>
			    		@{{address.consignee}}
			    		<small v-if="address.isDefault == 1">默认地址</small>
			    		<i class="fa fa-check active" v-if="address.isDefault"></i>
			    	</h4>
			    	<p>@{{address.phone}}</p>
			    	<p>@{{address.provinceName}} @{{address.cityName}} @{{address.districtName}}</p>
			    	<p>@{{address.address}}</p>
			    	<div class="address-btn">
			    		<div class="btn btn-success" 
			    			data-toggle="modal" 
			    			v-bind:data-target="'#myModal' +address.id">
			    			<i class="fa fa-edit"></i>
			    			编辑
			    		</div>
			    		<div class="btn btn-danger" v-on:click="delAddress(address.id)">
			    			<i class="fa fa-times"></i>
			    			删除
			    		</div>
			    	</div><!--/address-btn-->
			    	@include('smartisan.checkout.address_edit')
			    </div><!--/address-item-->
			</div><!--/col-md-3-->

			<div class="col-md-3">
				<div class="address-item">
					<div class="i-add" data-toggle="modal" data-target="#myModalNew">
					<i class="fa fa-plus"></i>
					<p>添加新地址</p>
					</div>
				</div><!--/address-item-->
				@include('smartisan.checkout.address_new')
			</div><!--/col-md-3-->
		</div>
	</div><!--/bb-->
</div><!--/panel-->
</div><!--/row-->
@include('smartisan.vue.address')