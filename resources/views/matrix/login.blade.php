@extends('matrix.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
<link href="{!!url('front/matrix/animate.css')!!}" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{!!url('front/matrix/js/jquery.validate.min.js')!!}"></script>


   <div class="login-box">
   @include('matrix.lib.user_breadcrumb')
   @include('matrix.lib.login_form')
   </div><!--/login-box-->


<script type="text/javascript">
	$(function(){
		front.login.validate("{!!url('auth/captcha-check')!!}");
        front.captcha("{!!url('captcha-ajax')!!}");
	});
</script>
@stop
