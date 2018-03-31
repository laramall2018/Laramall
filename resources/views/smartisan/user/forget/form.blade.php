<div class="dialog dialog-shadow" id="forgetroot">
<div class="dialog-bb">
	<div class="tit">
		<img src="{{url('front/smartisan/images/larastore.png')}}"
			 title="全网首款基于Laravel框架的商城系统" 
			 alt="全网首款基于Laravel框架的商城系统">
		<h4>忘记密码？重置账户密码</h4>
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
          <div class="row">
             <div class="col-md-8">
             <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-codepen"></i>
                  </div>
                  <input class="form-control input-lg" 
                   type="text" 
                   placeholder="验证码"
                   v-model="code"
                   name="code">
              </div><!--/input-group-->
              </div>
              <div class="col-md-4">
                 <span  v-on:click="sendSms"
                        class="btn btn-lg btn-default">获取验证码</span>
              </div><!--/col-md-4-->
          </div>
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
  			<span v-on:click="resetPassword"
  				  class="ls-btn-info fullwidth">
  				重置密码
  			</span>
  		</div><!--/form-group-->
  		<p>
  			<a href="{{url('auth/login')}}">返回登录</a>
  			<a href="{{url('auth/register')}}">注册</a>
  		</p>
  	
	</div><!--bb-->
</div><!--/dialog-bb-->
</div><!--/dailog-->
<script type="text/javascript">
   var forgetroot    = new Vue({
      el:'#forgetroot',
      data:{
              phone:'',
              code:'',
              password:'',
              isSend:0,
      },

      methods:{

            //获取短信验证码
            sendSms:function(){

                var  phone    = this.phone;
                $.ajax({
                  	url:"{{url('api/sendsms')}}",
                  	type:"POST",
                  	data:'phone='+phone,
                  	dataType:"json",
                  	success:function(data){
                    	var  content  = data.data;
                    	if(content.tag == 'error'){

                      		swal({
                                title: "错误提示",
                                text: content.info,
                                html: true,
                                type:"error"
                        	});
                        	return false;
                    	}
                    	if(content.tag == 'success'){
                        	forgetroot.isSend  = 1;
                        	swal({
                                title: "发送成功",
                                text: content.info,
                                html: true
                        	});
                    	}
                    }
                });
            },

             //确认注册
            resetPassword:function(){

                  var _this           = this;
                  var phone           = _this.phone;
                  var code            = _this.code;
                  var password        = _this.password;
                  


                  if(_this.isSend == 0){
                    swal({
                    	title:"错误提示",
                    	text:"请先获取短信验证码",
                    	type:"error"
                    });
                    return false;
                  }

                  $.ajax({
                    url:"{{url('api/reset-password')}}",
                    type:"POST",
                    data:'phone='+phone+'&code='+code + '&password=' + password,
                    dataType:'json',
                    success:function(data){
                      var  content  = data.data;
                      if(content.tag == 'error'){

                        swal({
                                title: "表单数据异常",
                                text: content.info,
                                html: true,
                                type:"error"
                        });
                        return false;
                      }

                      if(content.tag == 'success'){
                        swal("重置成功", "您已经成功重置密码", "success");
                        window.location.href ="{{url('auth/login')}}";
                      }

                    }
                  });
             },
      }

   })
</script>