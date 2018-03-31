{!!Form::open(['url'=>'auth/register','method'=>'post','class'=>'form-horizontal','id'=>'register-form'])!!}

  <div class="form-group">
    <label for="username" class="col-sm-4 control-label">{!!trans('front.username')!!}</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" id="username" name="username" placeholder="用户名称">
    </div>
  </div><!--/form-group-->
          <div class="form-group">
    <label for="phone" class="col-sm-4 control-label">{!!trans('front.phone')!!}</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" id="phone" name="phone" placeholder="手机号码">
    </div>
  </div><!--/form-group-->

  <div class="form-group">
    <label for="email" class="col-sm-4 control-label">{!!trans('front.email')!!}</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" id="email" name="email" placeholder="电子邮件">
    </div>
  </div><!--/form-group-->


          <div class="form-group">
            <label class="col-sm-4 control-label">{!!trans('front.password')!!}</label>
              <div class="col-sm-8">
                <input type="password" name="password" id="password" class="form-control" />
            </div>
          </div><!--/form-group-->
          <div class="form-group">
            <label class="col-sm-4 control-label">{!!trans('front.password_confirmation')!!}</label>
              <div class="col-sm-8">
                <input type="password" name="password_confirmation" class="form-control" />
            </div>
          </div><!--/form-group-->

          <div class="form-group">
            <label class="col-sm-4 control-label">{!!trans('front.captcha')!!}</label>
              <div class="col-sm-8">
                <input type="text" id="captcha" name="captcha" class="form-control" />
            </div>
          </div><!--/form-group-->

          <div class="form-group">
              <div class="col-sm-offset-4 col-sm-8">
                  <div class="captcha-img">{!! captcha_img('flat') !!}</div>
                </div>
          </div>



  <div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
      <button type="submit" class="btn btn-success">
              <i class="fa fa-user"></i>
              {!!trans('front.register_submit')!!}
      </button>
      <a href="{!!url('auth/login')!!}" class="btn btn-primary">
        {!!trans('front.login')!!}
        <span class="glyphicon glyphicon-arrow-right"></span>
      </a>
     </div>
  </div>
  
{!!Form::close()!!}
