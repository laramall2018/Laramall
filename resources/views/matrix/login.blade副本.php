@extends('matrix.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
<link href="{!!url('front/matrix/animate.css')!!}" rel="stylesheet" type="text/css" />
<link href="{{ CaptchaUrls::LayoutStylesheetUrl() }}" type="text/css" rel="stylesheet">
<script type="text/javascript" src="{!!url('front/matrix/js/jquery.validate.min.js')!!}"></script>

   @include('matrix.lib.breadcrumb')
   <div class="container">
   <div class="login-box">

        <div class="panel panel-success">
   		<div class="panel-heading">
        	<h5>{!!trans('front.login')!!}</h5>
        </div>
        <div class="panel-body">
        	<div class="login-box-bb" style="display:none">

            	{!!Form::open(['url'=>'auth/login','method'=>'post','class'=>'form-horizontal','id'=>'login-form'])!!}

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
                        	<input type="text" id="CaptchaCode" name="CaptchaCode" class="form-control" />
                    	</div>

                    </div><!--/form-group-->
                    <div class="form-group">
    					<div class="col-sm-offset-4 col-sm-8">
      						{!!$captcha!!}
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

        </div>
        </div>
   </div>

   </div>
   </div>
<script type="text/javascript">
	$(function(){
		front.login.validate();
	});
</script>
@stop
