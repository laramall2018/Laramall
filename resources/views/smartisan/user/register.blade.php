<div class="dialog dialog-shadow" id="regroot">
  
      <div class="dialog-heading">
          <h4 class="text-center">注册LaravelStore ID</h4>
      </div><!--/panel-heading-->
      
      <div class="register-content">
          <div class="form-group">
              <div class="input-group col-md-12">
                  <div class="input-group-addon">
                    <i class="fa fa-phone"></i>
                  </div>
                  <input class="form-control input-lg" 
                   type="text" 
                   placeholder="手机号码"
                   v-model="phone"
                   name="phone">
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
              <div class="input-group col-md-12">
                  <div class="input-group-addon">
                    <i class="fa fa-envelope"></i>
                  </div>
                  <input class="form-control input-lg" 
                   type="text" 
                   placeholder="电子邮件"
                   name="email"
                   v-model="email">
              </div><!--/input-group-->
          </div><!--/form-group-->

          

          <div class="form-group">
              <div class="input-group col-md-12">
                  <div class="input-group-addon">
                      <i class="fa fa-key"></i>
                  </div>
                  <input class="form-control input-lg" 
                   type="password"
                   placeholder="账号密码"
                   name="password"
                   v-model="password">
              </div><!--/input-group-->
          </div><!--/form-group-->

          <div class="form-group">
             <span class="checked-btn"
                   v-on:click="changeAgree"
                   v-bind:class="{'checked-on':agree == 1}"></span>
             我已阅读并同意网站免责条款
          </div><!--/form-group-->

          <div class="form-group">
              <span v-on:click="regAct"
                    class="ls-btn-info fullwidth">确认注册</span>
          </div><!--/form-group-->

          <div class="footer-item">
             <p>
               如果已经拥有账号，可以在此<a href="{{url('auth/login')}}">登录</a>
             </p>
          </div>

      </div><!--/register-content-->

</div><!--/dialog-->
<script type="text/javascript">
   var regroot    = new Vue({
      el:'#regroot',
      data:{
              phone:'',
              code:'',
              email:'',
              password:'',
              agree:1,
              isSend:1,
      },

      methods:{

             //获取短信验证码
             sendSms:function(){
                var  phone      = this.phone;
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
                                html: true
                        });
                        return false;
                    }
                    if(content.tag == 'success'){
                        regroot.isSend  = 1;
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
             regAct:function(){

                  var _this           = this;
                  var phone           = _this.phone;
                  var email           = _this.email;
                  var code            = _this.code;
                  var password        = _this.password;
                  var agree           = _this.agree;
                  

                  if(this.agree == 0){
                    swal('请阅读和同意网站免责条款');
                    return false;
                  }

                  if(this.isSend == 0){
                    swal('请先发送手机短信验证码');
                    return false;
                  }

                  $.ajax({
                    url:"{{url('api/register')}}",
                    type:"POST",
                    data:'phone='+phone+'&email='+email + '&code='+code + '&password=' + password,
                    dataType:'json',
                    success:function(data){
                      var  content  = data.data;
                      if(content.tag == 'error'){

                        swal({
                                title: "表单数据异常",
                                text: content.info,
                                html: true
                        });
                        return false;
                      }

                      if(content.tag == 'success'){
                        swal("注册成功", "您已经注册成功", "success");
                        window.location.href ="{{url('auth/center')}}";
                      }

                    }
                  });
             },

             //选择状态
             changeAgree:function(){
                if(this.agree == 1){
                   this.agree  = 0;
                }else{
                   this.agree  = 1;
                }
             },
      }

   })
</script>