@extends('materialize.layout.common')

@section('title')
	{!!$title!!}
@stop

@section('content')
	@include('materialize.lib.breadcrumb')
	@include('materialize.lib.users.register')
	<script type="text/javascript">
		$(function(){
			
			front.user.captcha("{!!url('captcha-ajax')!!}");
		})
	</script>
@stop