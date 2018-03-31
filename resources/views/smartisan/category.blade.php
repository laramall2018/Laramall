@extends('smartisan.layout.common')

@section('title')
{{$title}}
@stop

@section('content')
	<div class="main-box">
	    @include('smartisan.lib.breadcrumb')

	    <div id="catapp">
			@include('smartisan.category.select')
			@include('smartisan.category.goods_list')
			@include('smartisan.vue.category')
		</div>
	</div>
@stop