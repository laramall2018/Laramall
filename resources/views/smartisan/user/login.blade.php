<div class="dialog dialog-shadow" id="loginroot">
<div class="dialog-bb">
	<div class="tit">
		<img src="{{url('front/smartisan/images/larastore.png')}}"
			 title="全网首款基于Laravel框架的商城系统" 
			 alt="全网首款基于Laravel框架的商城系统">
		<h4>使用LaravelStore ID登录</h4>
	</div><!--/tit-->
	<div class="bb">
	
		<div class="form-group">
    		<div class="input-group">
      			<div class="input-group-addon">
      				<i class="fa fa-phone"></i>
      			</div>
      			<input class="form-control input-lg" 
      			       type="text" 
      			       placeholder="手机号码"
      			       v-model="phone">
    		</div><!--/input-group-->
  		</div><!--/form-group-->
		
		<div class="form-group">
    		<div class="input-group">
      			<div class="input-group-addon">
      				<i class="fa fa-lock"></i>
      			</div>
      			<input class="form-control input-lg" 
      			       type="password" 
      			       v-model="password">
    		</div><!--/input-group-->
  		</div><!--/form-group-->
  		<div class="form-group">
  			<span class="checked-btn"
  				  v-on:click="changeStatus"
  				  v-bind:class="{'checked-on':remember == 1}"></span>
  			记住我
  			<div class="right-btn">
  				<a href="{{url('auth/register')}}">注册账号</a>
  			    <a href="{{url('api/forget-password')}}">忘记密码</a>
  			</div>
  		</div><!--/form-group-->
  		<div class="form-group">
  			<span v-on:click="loginAct"
  				  class="ls-btn-info fullwidth">
  				确认登录
  			</span>
  		</div><!--/form-group-->
  	
	</div><!--bb-->
</div><!--/dialog-bb-->
</div><!--/dailog-->
<script type="text/javascript">
	var loginroot	= new Vue({
		el:'#loginroot',
		data:{
				phone:'',
				password:'',
				remember:1,
		},
		methods:{

				//动态改变是否选中记住我
				changeStatus:function(){
					var  tag  = 0;
				    if(this.remember == 0){
				    	tag  = 1;
				    }

				    this.remember 	= tag;
				},
				//登录表单
				loginAct:function(){
					var phone  			= this.phone;
					var password 		= this.password;
					$.ajax({
						url:"{{url('api/login')}}",
						type:"POST",
						data:"phone="+phone +'&password='+password,
						dataType:"json",
						success:function(data){
							var content  = data.data;
							if(content.tag == 'error'){
								swal({
                                	title: "错误提示",
                                	text: content.info,
                                	html: true
                        		});
                        		return false;
							}

							if(content.tag =='success'){
								swal("成功登陆!", "您已经成功登陆", "success");
								window.location.href ="{{url('auth/center')}}";
							}
						}
					})
				},
		},

	})
</script>