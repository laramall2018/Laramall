@extends('smartisan.layout.common')

@section('title')
{{$title}}
@stop

@section('content')
	<div class="main-box">
		@include('smartisan.lib.breadcrumb')
		<div class="row">
		<div class="panel panel-goods">
			<div class="panel-heading">
				<h4>信息提示</h4>
			</div><!--/panel-heading-->
			<div class="panel-body" style="padding: 20px;">
				<div class="alert alert-info">
					{!!$info!!}
				</div>
				<a href="{{$back_url}}">
					<i class="fa fa-back"></i>
					返回上一页
				</a>
			</div><!--/panel-body-->
		</div><!--/panel-->
		</div>
	</div><!--/main-box-->
@stop