@extends('matrix.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
<script src="{!!url('front/matrix/fancybox/jquery.fancybox.js')!!}" type="text/javascript"></script>
<link href="{!!url('front/matrix/fancybox/jquery.fancybox.css')!!}" type="text/css" rel="stylesheet">
	
	@include('matrix.lib.breadcrumb')
	@include('matrix.lib.message_list')
	   
@stop