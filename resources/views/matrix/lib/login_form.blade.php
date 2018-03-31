
<div class="login-form-content  z-depth-4">
<div class="login-tit">
  <i class="fa fa-users"></i>
  {!!trans('front.user_login')!!}
</div>

{!!Form::open(['url'=>'auth/login','method'=>'post','class'=>'form-horizontal','id'=>'login-form'])!!}

@if (count($errors) > 0)
  <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
@endif
    <div class="form-group">
      <label for="username" class="col-sm-4 control-label">{!!trans('front.username')!!}</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="username" name="username" placeholder="用户名称">
      </div>
    </div><!--/form-group-->

      <div class="form-group">
        <label class="col-sm-4 control-label">{!!trans('front.password')!!}</label>
          <div class="col-sm-6">
            <input type="password" name="password" class="form-control" />
        </div>
      </div><!--/form-group-->

      <div class="form-group">
        <label class="col-sm-4 control-label">{!!trans('front.captcha')!!}</label>
          <div class="col-sm-6">
            <input type="text" id="captcha" name="captcha" class="form-control" />
        </div>

      </div><!--/form-group-->
      <div class="form-group">
          <div class="col-sm-offset-4 col-sm-8">
            <div class="captcha-img">
              {!!captcha_img('flat')!!}
            </div>
        </div>
      </div>



      <div class="form-group">
          <div class="col-sm-offset-4 col-sm-8">
              <button type="submit" class="btn btn-success">
                <i class="fa fa-user"></i>
                {!!trans('front.login')!!}
              </button>
              <a href="{!!url('auth/register')!!}" class="btn btn-info">
                <i class="fa fa-arrow-circle-right"></i>
                {!!trans('front.register')!!}
              </a>
        </div>
      </div>

  {!!Form::close()!!}



</div><!--login-form-content-->
