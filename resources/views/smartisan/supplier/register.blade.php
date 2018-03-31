@extends('smartisan.layout.common')

@section('title')
{{$title}}
@stop

@section('content')
	<div class="main-box">
		@include('smartisan.lib.breadcrumb')
		<div class="row">
		@include('smartisan.supplier.register.form')
		</div>
	</div><!--/main-box-->
@stop