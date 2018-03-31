@extends('smartisan.layout.common')

@section('title')
{{$title}}
@stop

@section('content')
	<div class="main-box">
		@include('smartisan.index.slider')
		@include('smartisan.index.ad')
		@include('smartisan.index.recommend_goods')
	</div>
@stop