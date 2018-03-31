<div class="login-box" id="loginroot">
		
		<img src="{{url('admin/simple/images/larastore.png')}}" alt="" class="admin-logo">
		<div class="alert alert-success">
			<i class="fa fa-users"></i>
			<span>管理员登录</span>
		</div>
		<div class="form-group">
			<input type="text" class="form-control" v-model="username" placeholder="账号">
		</div>
		<div class="form-group">
			<input type="password" class="form-control" v-model="password" placeholder="密码">
		</div>
		<div class="form-group">
			<span class="ls-btn-info" v-on:click="adminLogin">确认登录</span>
			<span>本次登录IP：{{request()->ip()}}</span>
		</div>
	</div><!--/login-box-->
	<p class="copyright">
		<a href="https://laravelstore.net">
			@www.laravelstore.net版权所有
		</a>
	</p>