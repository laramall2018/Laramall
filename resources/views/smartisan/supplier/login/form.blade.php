<div class="supplier-box" id="sloginroot">
<div class="panel panel-goods">
	<div class="panel-heading">
		<h4 class="">供货商登录</h4>
	</div><!--/panel-heading-->
	<div class="panel-body" style="padding: 20px;">
		<form class="form-horizontal">
			<div class="form-group">
				<label for="" class="control-label col-md-2">姓名</label>
				<div class="col-md-9">
					<input type="text" v-model="username" class="form-control">
				</div>
			</div><!--/form-group-->

			<div class="form-group">
				<label for="" class="control-label col-md-2">登录密码</label>
				<div class="col-md-9">
					<input type="password" v-model="password" class="form-control">
				</div>
			</div><!--/form-group-->
			<div class="form-group">
				
				<div class="col-md-offset-2 col-md-9">
					<span class="ls-btn-info" v-on:click="supplierLogin">
						<i class="fa fa-check"></i>
						确认登录
					</span>
				</div>
			</div><!--/form-group-->

		</form>
	</div>
</div><!--/panel-goods-->
</div><!--/sregroot-->
@include('smartisan.vue.supplier.login')