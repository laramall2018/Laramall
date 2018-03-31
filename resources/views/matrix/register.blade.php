@extends('matrix.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
<link href="{!!url('front/matrix/animate.css')!!}" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{!!url('front/matrix/js/jquery.validate.min.js')!!}"></script>

   <div class="login-box">
   @include('matrix.lib.user_breadcrumb')
   <div class="login-form-content  z-depth-4">
   <div class="login-tit">
     <i class="fa fa-users"></i>
     {!!trans('front.register')!!}
   </div>
   @include('matrix.lib.register_form')
   </div>
 </div>

<script type="text/javascript">
	$(function(){
		front.register.validate("{!!url('auth/register-check')!!}","{!!url('auth/captcha-check')!!}");
    front.captcha("{!!url('captcha-ajax')!!}");
	});
</script>
@stop
