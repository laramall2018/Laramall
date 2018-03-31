
<div class="form-content-bb">
	<form class="form-horizontal">
	<div class="form-group">
		<label for="" class="col-md-2 control-label">用户名称</label>
		<div class="col-md-10">
			<input type="text" v-model="rows.username" class="form-control">
		</div>
	</div><!--/form-group-->
	
	<div class="form-group">
		<label for="" class="col-md-2 control-label">电子邮件</label>
		<div class="col-md-10">
			<input type="text" v-model="rows.email" class="form-control">
		</div>
	</div><!--/form-group-->

	<div class="form-group">
		<label for="" class="col-md-2 control-label">手机</label>
		<div class="col-md-10">
			<input type="text" v-model="rows.phone" class="form-control">
		</div>
	</div><!--/form-group-->

	<div class="form-group">
		<label for="" class="col-md-2 control-label">昵称</label>
		<div class="col-md-10">
			<input type="text" v-model="rows.nickname" class="form-control">
		</div>
	</div><!--/form-group-->

	<div class="form-group">
		<label for="" class="col-md-2 control-label">性别</label>
		<div class="col-md-10">
			<select name="sex" v-model="rows.sex" class="form-control">
				<option value="0">男</option>
				<option value="1">女</option>
				<option value="2">保密</option>
			</select>
		</div>
	</div><!--/form-group-->

	<div class="form-group">
		<label for="" class="col-md-2 control-label">生日</label>
		<div class="col-md-10">
			<input type="text" v-model="rows.birthday" class="form-control">
		</div>
	</div><!--/form-group-->

	<div class="form-group">
		<label for="" class="col-md-2 control-label">身份证</label>
		<div class="col-md-10">
			<input type="text" v-model="rows.sfz" class="form-control">
		</div>
	</div><!--/form-group-->

	<div class="form-group">
		<label for="" class="col-md-2 control-label">密码</label>
		<div class="col-md-10">
			<input type="text" v-model="password" class="form-control">
		</div>
	</div><!--/form-group-->

	<div class="form-group">
		<div class="col-md-10 col-md-offset-2">
			<span class="ls-btn-info" v-on:click="updateForm">
				确认编辑
			</span>
		</div>
	</div>

	</form><!--/form-->
</div><!--/content-bb-->