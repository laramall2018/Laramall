@extends('smartisan.layout.common')

@section('title')
{{$title}}
@stop

@section('content')
	<div class="main-box">
		@include('smartisan.lib.breadcrumb')
		<div class="row">
		@include('smartisan.brand.detail.info')
		@include('smartisan.brand.goods_list')
		</div>
	</div><!--/main-box-->
@stop