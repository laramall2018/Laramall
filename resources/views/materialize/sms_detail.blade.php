@extends('materialize.layout.common')
@section('title')
{!!$title!!}
@stop

@section('content')
@include('materialize.lib.breadcrumb')
<div class="row">
<div class="col s12">
<a href="{{$back_url}}" class="btn offset-top10">返回</a>
<div class="card-panel">
	
	<table class="table bordered striped">
			<tr>
				<th>用户名称</th>
				<td>{{$model->user->username}}</td>
			</tr>
			<tr>
				<th>消息内容</th>
				<td>{{$model->sms_content}}</td>
			</tr>
			<tr>
				<th>发送时间</th>
				<td>{{$model->post_time()}}</td>
			</tr>
			<tr>
				<th>ip</th>
				<td>{{$model->ip}}</td>
			</tr>
			@if($model->admin)
			<tr>
				<th>管理员</th>
				<td>{{$model->admin->username}}</td>
			</tr>
			@endif
			@if($model->reply_content)
			<tr>
				<th>回复内容</th>
				<td>{{$model->reply_content}}</td>
			</tr>
			<tr>
				<th>回复时间</th>
				<td>{{$model->reply_time()}}</td>
			</tr>
			@endif
	</table>
</div>
</div>
</div>

@stop