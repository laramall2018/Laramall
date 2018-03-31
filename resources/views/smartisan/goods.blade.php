@extends('smartisan.layout.common')

@section('title')
{{$title}}
@stop

@section('content')
	<div class="main-box">
	    @include('smartisan.lib.breadcrumb')
		@include('smartisan.goods.info')
		@include('smartisan.goods.comment')
		@include('smartisan.goods.field')
		@include('smartisan.goods.desc')
	</div>
@stop